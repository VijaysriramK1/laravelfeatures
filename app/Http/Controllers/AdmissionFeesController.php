<?php

namespace App\Http\Controllers;

use App\Models\AdmissionFees;
use App\Models\AdmissionFeesInvoice;
use App\Models\AdmissionFeesInvoiceChields;
use Illuminate\Support\Facades\Cache;
use App\Models\AdmissionPayment;
use App\Models\Feesadminsion;
use App\Models\StudentRecord;
use App\Models\User;
use App\SmAddIncome;
use App\SmAdmissionQuery;
use App\SmBankAccount;
use App\SmBankStatement;
use Illuminate\Support\Facades\Validator;
use App\SmClass;
use App\SmGeneralSettings;
use App\SmPaymentGatewaySetting;
use App\SmPaymentMethhod;
use App\SmSchool;
use App\SmStudent;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Fees\Entities\FmFeesGroup;
use Modules\Fees\Entities\FmFeesInvoice;
use Modules\Fees\Entities\FmFeesInvoiceChield;
use Modules\Fees\Entities\FmFeesInvoiceSettings;
use Modules\Fees\Entities\FmFeesTransaction;
use Modules\Fees\Entities\FmFeesTransactionChield;
use Modules\Fees\Entities\FmFeesType;
use Modules\Fees\Entities\FmFeesWeaver;
use Modules\Wallet\Entities\WalletTransaction;
use Yajra\DataTables\DataTables;

class AdmissionFeesController  extends Controller
{

    public function Admissionfessview()
    {

        $classes = SmClass::all();

        $paymentMethods = SmPaymentMethhod::whereIn('method', ["Cash", "Cheque", "Bank"])
            ->where('school_id', Auth::user()->school_id)
            ->get();

        $admissionfees = AdmissionFees::with('class')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('fees::feesInvoice.AdmissionFees', compact('admissionfees', 'classes', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'class_id' => 'required|array',
            'payment_method' => 'required|string',
            'amount' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $classIds = $request->input('class_id');

        foreach ($classIds as $classId) {
            $admissionfees = new AdmissionFees();
            $admissionfees->title = $request->input('title');
            $admissionfees->payment_method = $request->input('payment_method');
            $admissionfees->amount = $request->input('amount');
            $admissionfees->class_id = $classId;
            $admissionfees->status = $request->input('status');
            $admissionfees->user_id = Auth::id();
            $admissionfees->fees_group_id = null;
            $admissionfees->save();

            $storeTransaction = new StudentRecord();
            $storeTransaction->class_id = $admissionfees->class_id;
            $storeTransaction->roll_no = $admissionfees->id;
            $storeTransaction->school_id = Auth::user()->school_id;
            $storeTransaction->academic_id = getAcademicId();
            $storeTransaction->admission_fees_id = $admissionfees->id;
            $storeTransaction->save();
        }

        Toastr::success('Amount saved successfully!');
        return redirect()->route('admission_fees');
    }


    public function edit($id)
    {
        $item = AdmissionFees::findOrFail($id);
        $admissionfees = AdmissionFees::all();
        $admissionfees = AdmissionFees::paginate(5);
        $classes = SmClass::where('school_id', Auth::user()->school_id)->get();
        $paymentMethods = SmPaymentMethhod::whereIn('method', ["Cash", "Cheque", "Bank"])
            ->where('school_id', Auth::user()->school_id)->get();

        return view('fees::feesInvoice.AdmissionFees', compact('admissionfees', 'item', 'classes', 'paymentMethods'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'class_id' => 'required|array',
            'payment_method' => 'required|string',
            'amount' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $data = AdmissionFees::findOrFail($id);
        $data->update([
            'title' => $request->input('title'),
            'payment_method' => $request->input('payment_method'),
            'amount' => $request->input('amount'),
            'status' => $request->input('status'),
        ]);
        Toastr::success(' updated saved successfully');
        return redirect()->route('admission_fees');
    }


    public function destroy($id)
    {
        AdmissionFees::findOrFail($id)->delete();
        Toastr::error('Amount deleted successfully');
        return redirect()->route('admission_fees');
    }


    public function admissionfeesInvoiceList()
    {
        $admissionfeesinvoice = AdmissionFees::with('class')
            ->orderBy('id', 'desc')
            ->get();
        $admissionfee = SmAddIncome::orderBy('id', 'desc')->get();
        foreach ($admissionfeesinvoice as $admissionfees) {
            $relatedIncome = $admissionfee->first();
            $admissionfees->balance = $admissionfees->amount - ($relatedIncome ? $relatedIncome->amount : 0);
        }

        return view('fees::feesInvoice.admissionInvoice', compact('admissionfeesinvoice'));
    }


    public function admissionpayment(Request $request)
    {
        if ($request->total_paid_amount == null) {
            Toastr::warning('Paid Amount Can Not Be Blank', 'Failed');
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'payment_method' => 'required',
            'bank' => 'required_if:payment_method,Bank',
            'file' => 'mimes:jpg,jpeg,png,pdf',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $destination = 'public/uploads/student/document/';
        $file = fileUpload($request->file('file'), $destination);
        $record_id = $request->record_id;
        $record = AdmissionFeesInvoice::where('record_id', $record_id)->first();
        $student = SmAdmissionQuery::find($record->record_id);
        if ($request->add_wallet > 0) {
            $user = User::find($student->user_id);
            $walletBalance = $user->wallet_balance;
            $user->wallet_balance = $walletBalance + $request->add_wallet;
            $user->update();

            $addPayment = new WalletTransaction();
            $addPayment->amount = $request->add_wallet;
            $addPayment->payment_method = $request->payment_method;
            $addPayment->user_id = $user->id;
            $addPayment->type = 'diposit';
            $addPayment->status = 'approve';
            $addPayment->note = 'Fees Extra Payment Add';
            $addPayment->school_id = Auth::user()->school_id;
            $addPayment->academic_id = getAcademicId();
            $addPayment->save();

            $school = SmSchool::find($user->school_id);

            $compact['user_email'] = $user->email;
            $compact['full_name'] = $user->full_name;
            $compact['method'] = $request->payment_method;
            $compact['create_date'] = date('Y-m-d');
            $compact['school_name'] = $school->school_name;
            $compact['current_balance'] = $user->wallet_balance;
            $compact['add_balance'] = $request->total_paid_amount;
            $compact['previous_balance'] = $user->wallet_balance - $request->add_wallet;

            @send_mail($user->email, $user->full_name, "fees_extra_amount_add", $compact);

            //Notification
            sendNotification("Fees Xtra Amount Add", null, $student->user_id, 2);
        }

        $storeTransaction = new FmFeesTransaction();
        $storeTransaction->admission_invoice_id = $request->invoice_id;
        $storeTransaction->payment_note = $request->payment_note;
        $storeTransaction->payment_method = $request->payment_method;
        $storeTransaction->bank_id = $request->bank;
        $storeTransaction->student_id = $student->id;
        $storeTransaction->record_id = $request->record_id;
        $storeTransaction->user_id = Auth::user()->id;
        $storeTransaction->file = $file;
        $storeTransaction->paid_status = 'approve';
        $storeTransaction->school_id = Auth::user()->school_id;
        $storeTransaction->academic_id = getAcademicId();
        $storeTransaction->save();

        foreach ($request->fees_type as $key => $type) {
            $id = AdmissionFeesInvoiceChields::where('admission_fees_invoice_id', $request->invoice_id)->where('fees_type', $type)->first('id')->id;

            $storeFeesInvoiceChield = AdmissionFeesInvoiceChields::find($id);
            $storeFeesInvoiceChield->weaver = $request->weaver[$key];
            $storeFeesInvoiceChield->due_amount = $request->due[$key];
            $storeFeesInvoiceChield->paid_amount = $storeFeesInvoiceChield->paid_amount + ($request->paid_amount[$key] - $request->extraAmount[$key]);
            $storeFeesInvoiceChield->fine = $storeFeesInvoiceChield->fine + $request->fine[$key];
            $storeFeesInvoiceChield->update();

            $admissionFeesInvoiceChields = AdmissionFeesInvoiceChields::where('admission_fees_invoice_id', $request->invoice_id)->get();

            $totalDue = $admissionFeesInvoiceChields->sum('due_amount');
            $totalPaid = $admissionFeesInvoiceChields->sum('paid_amount');

            if ($totalDue == 0) {
                $paymentStatus = 'paid';
            } elseif ($totalPaid > 0) {
                $paymentStatus = 'partial';
            } else {
                $paymentStatus = 'unpaid';
            }

            $admissionFeesInvoice = AdmissionFeesInvoice::find($request->invoice_id);
            if ($admissionFeesInvoice) {
                $admissionFeesInvoice->payment_status = $paymentStatus;

                $admissionFeesInvoice->update();
            }

            if ($request->paid_amount[$key] > 0) {
                $storeTransactionChield = new FmFeesTransactionChield();
                $storeTransactionChield->fees_transaction_id = $storeTransaction->id;
                $storeTransactionChield->fees_type = $type;
                $storeTransactionChield->weaver = $request->weaver[$key];
                $storeTransactionChield->fine = $request->fine[$key];
                $storeTransactionChield->paid_amount = $request->paid_amount[$key];
                $storeTransactionChield->note = $request->note[$key];
                $storeTransactionChield->school_id = Auth::user()->school_id;
                $storeTransactionChield->academic_id = getAcademicId();
                $storeTransactionChield->save();
            }

            // Income
            $payment_method = SmPaymentMethhod::where('method', $request->payment_method)->first();
            $income_head = generalSetting();

            $add_income = new SmAddIncome();
            $add_income->name = 'Fees Collect';
            $add_income->date = date('Y-m-d');
            $add_income->amount = $request->paid_amount[$key];
            $add_income->fees_collection_id = $storeTransaction->id;
            $add_income->active_status = 1;
            $add_income->income_head_id = $income_head->income_head_id;
            $add_income->payment_method_id = $payment_method->id;
            if ($payment_method->id == 3) {
                $add_income->account_id = $request->bank;
            }
            $add_income->created_by = Auth()->user()->id;
            $add_income->school_id = Auth::user()->school_id;
            $add_income->academic_id = getAcademicId();
            $add_income->save();

            // Bank
            if ($request->payment_method == "Bank") {
                $payment_method = SmPaymentMethhod::where('method', $request->payment_method)->first();
                $bank = SmBankAccount::where('id', $request->bank)
                    ->where('school_id', Auth::user()->school_id)
                    ->first();
                $after_balance = $bank->current_balance + $request->paid_amount[$key];

                $bank_statement = new SmBankStatement();
                $bank_statement->amount = $request->paid_amount[$key];
                $bank_statement->after_balance = $after_balance;
                $bank_statement->type = 1;
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
            }
        }
        //Notification
        sendNotification("Add Fees Payment", null, $student->user_id, 2);
        sendNotification("Add Fees Payment", null, $student->user_id, 3);

        Toastr::success('Save Successful', 'Success');
        return redirect()->route('admissionfees-invoice-list');
    }

    public function admissionfeesInvoiceDelete(Request $request)
    {
        try {
            $invoiceDelete = AdmissionFeesInvoice::find($request->feesInvoiceId)->delete();
            if ($invoiceDelete) {
                AdmissionFeesInvoiceChields::where('admission_fees_invoice_id', $request->id)->delete();
            }
            Toastr::success('Delete Successful', 'Success');
            return redirect()->route('admissionfees-invoice-list');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function Admissioninvoiceedit($id)
    {
        $item = AdmissionFees::findOrFail($id);
        $admissionfees = AdmissionFees::all();
        $admissionfees = AdmissionFees::paginate(5);
        $classes = SmClass::where('school_id', Auth::user()->school_id)->get();
        $paymentMethods = SmPaymentMethhod::whereIn('method', ["Cash", "Cheque", "Bank"])
            ->where('school_id', Auth::user()->school_id)->get();

        return view('fees::feesInvoice.AdmissionFees', compact('admissionfees', 'item', 'classes', 'paymentMethods'));
    }


    public function admissioninvoiceupdate(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'class_id' => 'required|array',
            'payment_method' => 'required|string',
            'amount' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $data = AdmissionFees::findOrFail($id);
        $data->update([
            'title' => $request->input('title'),
            'payment_method' => $request->input('payment_method'),
            'amount' => $request->input('amount'),
            'status' => $request->input('status'),
        ]);
        Toastr::success('Amount updated successfully', 'Update');
        return redirect()->route('admissionfees-invoice-list');
    }

    public function admissionFeesInvoiceView($id, $state)
    {
        $generalSetting = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();
        $invoiceInfo = AdmissionFeesInvoice::find($id);

        $invoiceDetails = AdmissionFeesInvoiceChields::where('admission_fees_invoice_id', $invoiceInfo->id)
            ->where('school_id', Auth::user()->school_id)
            ->where('academic_id', getAcademicId())
            ->get();
        $banks = SmBankAccount::where('active_status', '=', 1)
            ->where('school_id', Auth::user()->school_id)
            ->get();

        if ($state == 'view') {
            return view('fees::feesInvoice.admissionFeesInvoiceView', compact('generalSetting', 'invoiceInfo', 'invoiceDetails', 'banks'));
        } else {
            return view('fees::feesInvoice.admissionFeesInvoicePrint', compact('invoiceInfo', 'invoiceDetails', 'banks'));
        }
    }

    public function adminAddFeesPayment($id)
    {
        $classes = SmClass::where('school_id', Auth::user()->school_id)
            ->where('academic_id', getAcademicId())
            ->get();

        $feesGroups = FmFeesGroup::where('school_id', Auth::user()->school_id)
            ->where('academic_id', getAcademicId())
            ->get();

        $feesTypes = FmFeesType::where('school_id', Auth::user()->school_id)
            ->where('academic_id', getAcademicId())
            ->get();

        $feesTypes = FmFeesType::where('type', 'fees')
            ->where('school_id', Auth::user()->school_id)
            ->where('academic_id', getAcademicId())
            ->get();

        $paymentMethods = SmPaymentMethhod::whereIn('method', ["Cash", "Cheque", "Bank"])
            ->where('active_status', 1)
            ->where('school_id', Auth::user()->school_id)
            ->get();

        $bankAccounts = SmBankAccount::where('school_id', Auth::user()->school_id)
            ->where('academic_id', getAcademicId())
            ->get();

        $invoiceInfo = AdmissionFeesInvoice::findOrFail($id);
        $invoiceDetails = AdmissionFeesInvoiceChields::where('admission_fees_invoice_id', $invoiceInfo->id)
            ->where('school_id', Auth::user()->school_id)
            ->where('academic_id', getAcademicId())
            ->get();

        $stripe_info = SmPaymentGatewaySetting::where('gateway_name', 'stripe')
            ->where('school_id', Auth::user()->school_id)
            ->first();


        return view('fees::student.adminAddPayment',  compact('classes', 'feesGroups', 'feesTypes', 'paymentMethods', 'bankAccounts', 'invoiceInfo', 'invoiceDetails', 'stripe_info'));
    }

    public function admissionfeesInvoiceDatatable(Request $request)
    {
        $query = AdmissionFeesInvoice::with('studentInfo')
            ->select('admission_fees_invoices.*')
            ->where('school_id', Auth::user()->school_id)
            ->where('academic_id', getAcademicId());


        $orderColumnIndex = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');
        $sortableColumns = [
            'student name' => 'student_name',
            'amount' => 'Tamount',
            'paid_amount' => 'Tpaidamount',
            'balance' => 'balance',
            'status' => 'status',
            'created_date' => 'created_at'
        ];

        $orderColumn = $sortableColumns[$orderColumnIndex] ?? 'created_at';
        if ($orderColumn === 'balance') {

            $query->orderByRaw('Tamount + Tfine - (Tpaidamount + Tweaver) ' . $orderDirection);
        } else {
            $query->orderBy($orderColumn, $orderDirection);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('student name', function ($row) {
                return '<a href="' . route('fees.admissionfees-invoice-view', ['id' => $row->id, 'state' => 'view']) . '" target="_blank">' . @$row->studentInfo->name . '</a>';
            })
            ->addColumn('amount', function ($row) {
                return $row->Tamount;
            })
            ->addColumn('weaver', function ($row) {
                return $row->Tweaver;
            })
            ->addColumn('fine', function ($row) {
                return $row->Tfine;
            })
            ->addColumn('paid_amount', function ($row) {
                return $row->Tpaidamount;
            })
            ->addColumn('balance', function ($row) {
                $balance = $row->Tamount + $row->Tfine - ($row->Tpaidamount + $row->Tweaver);
                return $balance;
            })
            ->addColumn('status', function ($row) {
                $balance = $row->Tamount + $row->Tfine - ($row->Tpaidamount + $row->Tweaver);
                if ($balance == 0) {
                    return '<button class="primary-btn small bg-success text-white border-0">' . __('fees.paid') . '</button>';
                } elseif ($row->Tpaidamount > 0) {
                    return '<button class="primary-btn small bg-warning text-white border-0">' . __('fees.partial') . '</button>';
                } else {
                    return '<button class="primary-btn small bg-danger text-white border-0">' . __('fees.unpaid') . '</button>';
                }
            })
            ->addColumn('created_date', function ($row) {
                return dateConvert($row->created_at);
            })
            ->addColumn('action', function ($row) {
                $view = view('fees::admissioninvoiceListAction', [
                    'row' => $row,
                    'balance' => $row->Tamount + $row->Tfine - ($row->Tpaidamount + $row->Tweaver),
                    'paid_amount' => $row->Tpaidamount,
                    'role' => 'admin'
                ]);
                return (string)$view;
            })
            ->rawColumns(['student name', 'status', 'action'])
            ->make(true);
    }

    //Payment View

    public function admissionPaymentView($id, $type)
    {
        $generalSetting = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();

        $transcationInfo = FmFeesTransaction::find($id);

        $transcationDetails = FmFeesTransactionChield::where('fees_transaction_id', $transcationInfo->id)
            ->where('school_id', Auth::user()->school_id)
            ->where('academic_id', getAcademicId())
            ->get();

        $invoiceInfo = AdmissionFeesInvoice::find($transcationInfo->admission_invoice_id);

        if ($type == 'view') {
            return view('fees::feesInvoice.admissionSingleView', compact('generalSetting', 'invoiceInfo', 'transcationDetails', 'id'));
        } else {
            return view('fees::feesInvoice.admissionSinglePrint', compact('generalSetting', 'invoiceInfo', 'transcationDetails'));
        }
    }

    //Delete View Payment

    public function admissionDeleteSingleFeesTranscation($id)
    {

        $total_amount = 0;
        $transcation = FmFeesTransaction::find($id);
        $allTranscations = FmFeesTransactionChield::where('fees_transaction_id', $transcation->id)->get();
        foreach ($allTranscations as $key => $allTranscation) {
            $total_amount += $allTranscation->paid_amount;

            $transcationId = FmFeesTransaction::find($allTranscation->fees_transaction_id);


            $fesInvoiceId = AdmissionFeesInvoice::where('admission_fees_id', $transcationId->admission_invoice_id)

                ->first();

            $storeFeesInvoiceChield = AdmissionFeesInvoiceChields::find($fesInvoiceId->id);
            $storeFeesInvoiceChield->due_amount = $storeFeesInvoiceChield->due_amount + $allTranscation->paid_amount;
            $storeFeesInvoiceChield->paid_amount = $storeFeesInvoiceChield->paid_amount - $allTranscation->paid_amount;
            $storeFeesInvoiceChield->update();
            $fees_inv = AdmissionFeesInvoice::find($transcationId->fees_invoice_id);
            if ($fees_inv) {
                $cache_key = 'have_due_fees_' . $transcationId->user_id;
                Cache::rememberForever($cache_key, function () {
                    return true;
                });
            }
        }

        if ($transcation->payment_method == "Wallet") {
            $user = User::find($transcation->user_id);
            $user->wallet_balance = $user->wallet_balance + $total_amount;
            $user->update();

            $addPayment = new WalletTransaction();
            $addPayment->amount = $total_amount;
            $addPayment->payment_method = $transcation->payment_method;
            $addPayment->user_id = $user->id;
            $addPayment->type = 'fees_refund';
            $addPayment->status = 'approve';
            $addPayment->note = 'Fees Payment';
            $addPayment->school_id = Auth::user()->school_id;
            $addPayment->academic_id = getAcademicId();
            $addPayment->save();
        }

        SmAddIncome::where('fees_collection_id', $id)->delete();
        $transcation->delete();

        //Notification
        $student = SmAdmissionQuery::find($transcation->admission_invoice_id);
        sendNotification("Delete Fees Payment", null, 1, 1);
        sendNotification("Delete Fees Payment", null, $student->user_id, 2);
        sendNotification("Delete Fees Payment", null, $student->user_id, 3);

        Toastr::success('Delete Successful', 'Success');
        return redirect()->route('fees.fees-invoice-list');
    }
}
