<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Supports\Facades\Exception;
use Illuminate\Support\Facades\Validator;
use App\SmAdmissionQuery;
use Log;
use Illuminate\Support\Facades\Auth;
use App\SmSetupAdmin;
use App\SmStaff;
use App\SmClass;
use Modules\Fees\Entities\FmFeesInvoice;
use App\Models\AdmissionFees;
use Modules\Fees\Entities\FmFeesInvoiceChield;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;
use App\SmGeneralSettings;
use App\Models\AdmissionFeesInvoice;
use App\Models\AdmissionFeesInvoiceChields;
use App\SmBankAccount;
use App\SmBankStatement;
use App\SmContactPage;
use App\SmExam;
use App\SmExamType;
use App\SmPaymentMethhod;
use App\SmSection;
use App\SmSubject;
use Illuminate\Support\Facades\DB;
use Modules\Fees\Entities\FmFeesTransaction;
use Modules\Fees\Entities\FmFeesTransactionChield;
use Modules\Fees\Entities\FmFeesWeaver;

class LeadFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $sources = SmSetupAdmin::where('type', 3)->where('school_id',auth()->user()->school_id)->get();
        $status = SmSetupAdmin::where('type',5)->where('school_id',auth()->user()->school_id)->get();
        $classes = SmClass::where('active_status',1)->where('school_id',auth()->user()->school_id)->get();
        return view('lead_form',compact('sources','status','classes'));
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request != ''){
            $input = $request->all();
            $firstName = $request->first_name;
            $lastName = $request->last_name;
            $email = $request->email;
            $phone = $request->mobile;
            $class = $request->class;

            $rules = [
              'first_name' => ['string','required'],
              'last_name' => ['string','required'],
              'email' => ['string','required','email','unique:sm_admission_queries'],
              'mobile' => ['string','required'],
              'class' => ['integer','required'],
            ];

            $validator = Validator::make($input,$rules);
            if($validator->fails()){
              return redirect()->back()->withErrors($validator)->withInput();
            }
           

            $assignedData = SmStaff::where('general_staff_status',1)->where('active_status',1)->where('school_id',auth()->user()->school_id)->first();
            $sourceData = SmSetupAdmin::where('general_status',1)->where('type',3)->where('active_status',1)->where('school_id',auth()->user()->school_id)->first();
            $statusData = SmSetupAdmin::where('general_status',1)->where('type',5)->where('active_status',1)->where('school_id',auth()->user()->school_id)->first();
          
         
            $name = $input['first_name']  .' '. $input['last_name'];
            
            $data = new SmAdmissionQuery(); 
            $data->name = $name;
            $data->email = $input['email'];
            $data->phone = $input['mobile'];
            $data->description = $input['description'] ?? NULL;
            $data->address = $input['address'] ?? NULL;
            $data->date = isset($input['date']) ? date('Y-m-d', strtotime($request->date)) : NULL;
            $data->follow_up_date = isset($input['follow_up_date']) ? date('Y-m-d', strtotime($request->follow_up_date)) : NULL;
            $data->next_follow_up_date = isset($input['next_follow_up_date']) ? date('Y-m-d', strtotime($request->next_follow_up_date)) : NULL;
            $data->assigned = $assignedData->id ?? NULL;
            $data->reference = $input['reference'] ?? NULL;
            $data->source =  $sourceData->id ?? NULL;
            $data->no_of_child = $input['no_of_child'] ?? NULL;
            $data->active_status = $input['active_status'] ?? 1;
            $data->student_status = 1;
            $data->class =  $class ?? NULL;
            $data->created_by = Auth::user()->id;
            $data->updated_by = 1;
            $data->school_id  = Auth::user()->school_id;
            $data->academic_id  = getAcademicId();
            $data->save();
            $data->id;

            $feesDetails = AdmissionFees::where('class_id',$request->class)->where('status','active')->where('school_id',auth()->user()->school_id)->orderBy('id', 'DESC')->first();
            
            $invoice =  new AdmissionFeesInvoice();
            $invoice->invoice_id = 'INV-' . mt_rand(1, 999);
            $invoice->student_id =  $data->id;
            $invoice->class_id = $data->class;
            $invoice->payment_status = 'Unpaid';
            $invoice->payment_method = $input['payment_method'] ?? NULL ;
            $invoice->bank_id =  $input['bank_id'] ?? NULL ;
            $invoice->type =  $input['type'] ?? NULL ;
            $invoice->school_id =  Auth::user()->school_id;
            $invoice->academic_id =  getAcademicId();
            $invoice->active_status =  $input['active_status'] ?? 1 ;
            $invoice->record_id =  $feesDetails->id  ?? NULL ;
            $invoice->admission_fees_id =   $feesDetails->id ?? NULL ;
            $invoice->save();
            $invoice->id;
           
            $storeTransaction = new FmFeesTransaction();
            $storeTransaction->payment_method = $request->payment_method;
            $storeTransaction->bank_id = $request->bank ?? 'NULL';
            $storeTransaction->admission_invoice_id = $invoice->id;
            $storeTransaction->record_id =  $invoice->id;
            $storeTransaction->user_id = Auth::user()->id;
            $storeTransaction->paid_status = 'approve';
            $storeTransaction->school_id =  Auth::user()->school_id;
            $storeTransaction->academic_id = getAcademicId();
            $storeTransaction->save();

            $invoiceChild = new AdmissionFeesInvoiceChields();
            $invoiceChild->admission_fees_invoice_id  =  $invoice->id ?? NULL ;
            $invoiceChild->fees_type  = 2;
            $invoiceChild->amount  = $feesDetails->amount;
            $invoiceChild->paid_amount = $request->paid_amount ?? 0;
            $invoiceChild->weaver = $request->weaver ?? 0;
            $invoiceChild->sub_total = $feesDetails->amount;
            $invoiceChild->note = $request->note ?? 0;
            if ($request->paid_amount ?? 0 > 0) {
                $invoiceChild->paid_amount = $request->paid_amount ?? 0;
                $invoiceChild->due_amount = bcsub($request->sub_total ?? 0, $request->paid_amount ?? 0);
            } else {
                $invoiceChild->due_amount =$feesDetails->amount ?? 0;
            }
            $invoiceChild->school_id = Auth::user()->school_id;
            $invoiceChild->academic_id = getAcademicId();
            $invoiceChild->save();

            $storeTransactionChield = new FmFeesTransactionChield();
            $storeTransactionChield->fees_transaction_id = $storeTransaction->id;
            $storeTransactionChield->fees_type = $type ?? 2;
            $storeTransactionChield->weaver = $request->weaver ?? 0;
            $storeTransactionChield->paid_amount = $request->paid_amount ?? 0;
            $storeTransactionChield->note = $request->note ?? 0;
            $storeTransactionChield->school_id = Auth::user()->school_id;
            $storeTransactionChield->academic_id = getAcademicId();
            $storeTransactionChield->save();
          
            if ($request->payment_method == "Bank") {
                $payment_method = SmPaymentMethhod::where('method', $request->payment_method)->first();
                $bank = SmBankAccount::where('id', $request->bank)
                    ->where('school_id', Auth::user()->school_id)
                    ->first();
                $after_balance = $bank->current_balance + $request->paid_amount ?? 0;

                $bank_statement = new SmBankStatement();
                $bank_statement->amount = $request->paid_amount ?? 0;
                $bank_statement->after_balance = $after_balance;
                $bank_statement->type = 2;
                $bank_statement->details = "Fees Payment";
                $bank_statement->item_sell_id = $storeTransaction->id;
                $bank_statement->payment_date = date('Y-m-d');
                $bank_statement->bank_id = $request->bank;
                $bank_statement->school_id = Auth::user()->school_id;
                $bank_statement->payment_method = $payment_method->id;
                $bank_statement->save();

                $current_balance = SmBankAccount::find($request->bank);
                $current_balance->current_balance = $after_balance;
                $current_balance->update();

                $storeWeaver = new FmFeesWeaver();
                $storeWeaver->fees_invoice_id = $invoice->id;
                $storeWeaver->fees_type = $type ?? 2;
                $storeWeaver->student_id = $request->student;
                $storeWeaver->weaver = $request->weaver ?? 0;
                $storeWeaver->note = $request->note ?? 0;
                $storeWeaver->school_id = Auth::user()->school_id;
                $storeWeaver->academic_id = getAcademicId();
                $storeWeaver->save();
            }
               
                Session::flash('success','Created Successfully.Please Check your mail to see more details');
                return redirect()->back();
                

      }else{
    
        Session::flash('error','Something went Wrong...!');
          return redirect()->back();
      }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



    public function ContactForm(Request $request)
    {
        $status = $request->status;


       if($status == "true"){

        $is_contact_form_enabled = SmGeneralSettings::where('is_contact_form_enabled',NULL)->orWhere('is_contact_form_enabled', 0)->update(['is_contact_form_enabled' => 1]);

        return response()->json(['status' => $is_contact_form_enabled],200);
        
       }elseif($status == "false") {

        $is_contact_form_enabled = SmGeneralSettings::where('is_contact_form_enabled',1)->update(['is_contact_form_enabled' => 0]);
       
        return response()->json(['status' => 'Failed']);

        }else{

        return response()->json(['status'=> 'Something Went Wrong...!']);

        }
    
    }


    public function LeadToggleLightContactForm()
    {
        $exams = SmExam::where('school_id', app('school')->id)->get();
        $exams_types = SmExamType::where('school_id', app('school')->id)->get();
        $classes = SmClass::where('school_id', app('school')->id)->where('active_status', 1)->get();
        $subjects = SmSubject::where('school_id', app('school')->id)->where('active_status', 1)->get();
        $sections = SmSection::where('school_id', app('school')->id)->where('active_status', 1)->get();

        $contact_info = SmContactPage::where('school_id', app('school')->id)->first();

        $sources = DB::table('sm_setup_admins')->where('type', 3)->get();
        $status = DB::table('sm_setup_admins')->where('type',5)->get();
        $assignees = DB::table('sm_staffs')->where('active_status',1)->get();


        $storedSourceId = DB::table('sm_setup_admins')->where('type', 3)->where('general_status', 1)->pluck('id')->first();
        $storedStatusId = DB::table('sm_setup_admins')->where('type', 5)->where('general_status', 1)->pluck('id')->first();
        $storedAssignedId = DB::table('sm_staffs')->where('active_status', 1)->where('general_staff_status', 1)->pluck('id')->first();


        // $sources = SmSetupAdmin::where('type', 3)->where('school_id',auth()->user()->school_id)->get();
        // $status = SmSetupAdmin::where('type',5)->where('school_id',auth()->user()->school_id)->get();
        // $classes = SmClass::where('active_status',1)->where('school_id',auth()->user()->school_id)->get();
        return view('frontEnd.home.light_contact',compact('exams', 'classes', 'subjects', 'exams_types', 'sections', 'contact_info','sources','status','assignees','storedSourceId','storedStatusId','storedAssignedId'));
       
    }

    
}
