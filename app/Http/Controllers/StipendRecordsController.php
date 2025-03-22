<?php

namespace App\Http\Controllers;

use App\Models\AdmissionFeesInvoice;
use App\Models\ScholarShips;
use App\Models\Stipend;
use App\Models\StipendPayment;
use App\Models\StudentRecord;
use App\Models\StudentScholarship;
use App\Models\User;
use App\SmAddIncome;
use App\SmBankAccount;
use App\SmBankStatement;
use App\SmClass;
use App\SmPaymentGatewaySetting;
use App\SmPaymentMethhod;
use App\SmSchool;
use App\SmStudent;
use App\SmStudentGroup;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Craftsys\Msg91\Support\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Fees\Entities\FmFeesGroup;
use Modules\Fees\Entities\FmFeesType;
use Yajra\DataTables\DataTables;
use App\Jobs\Scholarship\StipendJob;
use App\SmGeneralSettings;

class StipendRecordsController extends Controller
{
    public function index()
    {
        $classes = SmClass::all();
        return view('scholarship.stipend_records', compact('classes'));
    }


    public function stipendrecordsdatatable(Request $request)
    {
        $students = SmStudent::where('user_id', Auth::user()->id)->pluck('id');
        $query = StipendPayment::with(['student', 'stipends', 'record.class', 'record.section'])
            ->select(
                'stipend_payments.id',
                'stipend_payments.student_id',
                'stipend_payments.stipends_amount',
                'stipend_payments.amount as paid_amount',
                'stipend_payments.payment_date',
                'stipend_payments.payment_method',
                'stipend_payments.start_date',
                'stipend_payments.end_date'
            );

        if (Auth::user()->role_id == 2) {
            $query->whereIn('stipend_payments.student_id', $students);
        }
        if ($request->has('status_filter') && $request->status_filter !== '') {
            $status = $request->status_filter;

            if ($status === 'paid') {
                $query->whereRaw('stipend_payments.amount >= stipend_payments.stipends_amount');
            } elseif ($status === 'partial') {
                $query->whereRaw('stipend_payments.amount > 0 AND stipend_payments.amount < stipend_payments.stipends_amount');
            } elseif ($status === 'unpaid') {
                $query->whereRaw('stipend_payments.amount = 0');
            }
        }


        if ($request->has('awarded_date') && $request->awarded_date !== null) {
            try {
                list($startDate, $endDate) = explode(' to ', $request->awarded_date);
                $query->whereBetween('stipend_payments.end_date', [
                    Carbon::parse($startDate)->format('Y-m-d'),
                    Carbon::parse($endDate)->format('Y-m-d')
                ]);
            } catch (\Exception $e) {
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('student_name', function ($row) {
                return $row->student
                    ? '<a href="' . route('stipend-records-view', ['id' => $row->id, 'state' => 'view']) . 'target="_blank">' . @$row->student->full_name . '</a>'
                    : 'N/A';
            })
            ->addColumn('class', function ($row) {
                return $row->record && $row->record->class ? $row->record->class->class_name : 'N/A';
            })
            ->addColumn('section', function ($row) {
                return $row->record && $row->record->section ? $row->record->section->section_name : 'N/A';
            })
            ->addColumn('stipend_amount', function ($row) {
                return number_format($row->stipends_amount, 2, '.', ',');
            })
            ->addColumn('status', function ($row) {
                $total_paid = $row->paid_amount;

                $status_class = 'bg-danger';
                $status_text = __('fees.unpaid');

                if ($total_paid >= $row->stipends_amount) {
                    $status_class = 'bg-success';
                    $status_text = __('fees.paid');
                } elseif ($total_paid > 0 && $total_paid < $row->stipends_amount) {
                    $status_class = 'bg-warning';
                    $status_text = __('fees.partial');
                }

                return '<button class="primary-btn small ' . $status_class . ' text-white border-0">' . $status_text . '</button>';
            })
            ->addColumn('awarded_date', function ($row) {
                return $row->end_date ? Carbon::parse($row->end_date)->format('d-m-Y') : 'N/A';
            })
            ->addColumn('action', function ($row) {
                $view = view('scholarship.stipend_records_action', [
                    'row' => $row,
                    'balance' => $row->stipends_amount - $row->paid_amount,
                    'paid_amount' => $row->paid_amount,
                    'role' => 'admin'
                ]);
                return (string)$view;
            })
            ->rawColumns(['student_name', 'status', 'action'])
            ->make(true);
    }



    public function addstipendrecordsPayment($id)
    {
        try {
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

            $invoiceInfo = StipendPayment::findOrFail($id);
            $invoiceDetails = StipendPayment::where('id', $id)
                ->get();
            $invoicenddate = StudentScholarship::where('student_id', $invoiceInfo->student_id)->first();
            $dueamount = $invoiceInfo->stipends_amount - $invoiceDetails->sum('amount');

            $stripe_info = SmPaymentGatewaySetting::where('gateway_name', 'stripe')
                ->where('school_id', Auth::user()->school_id)
                ->first();

            return view('scholarship.stipend_records_payment',  compact('invoicenddate', 'classes', 'feesGroups', 'feesTypes', 'paymentMethods', 'bankAccounts', 'invoiceInfo', 'invoiceDetails', 'stripe_info', 'dueamount'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function stipendrecordspayment(Request $request, $id)
    {

        $stipendamount = StipendPayment::where('id', $id)->first();



        $stipendamount->amount += $request->paid_amount;
        $stipendamount->payment_method = $request->payment_method;
        $stipendamount->payment_date = $request->payment_date ? $request->payment_date : null;
        $stipendamount->save();

        if ($request->payment_method == "Bank") {
            $payment_method = SmPaymentMethhod::where('method', $request->payment_method)->first();
            $bank = SmBankAccount::where('id', $request->bank)
                ->where('school_id', Auth::user()->school_id)
                ->first();
            $after_balance = $bank->current_balance + $request->paid_amount;

            $bank_statement = new SmBankStatement();
            $bank_statement->amount = $request->paid_amount;
            $bank_statement->after_balance = $after_balance;
            $bank_statement->type = 1;
            $bank_statement->details = "Fees Payment";
            $bank_statement->item_sell_id = $stipendamount->id;
            $bank_statement->payment_date = date('Y-m-d');
            $bank_statement->bank_id = $request->bank;
            $bank_statement->school_id = Auth::user()->school_id;
            $bank_statement->payment_method = $payment_method->id;
            $bank_statement->save();

            $current_balance = SmBankAccount::find($request->bank);
            $current_balance->current_balance = $after_balance;
            $current_balance->update();
        }

        $job = (new StipendJob($stipendamount, 'paymentcredited'))->delay(Carbon::now()->addSeconds(10));
        dispatch($job);

        Toastr::success('Save Successful', 'Success');
        return redirect()->route('stipend-records');
    }

    public function admissionfeesInvoiceDelete(Request $request)
    {
        $stipendAmount = StipendPayment::where('id', $request->feesInvoiceId)->delete();
        Toastr::success('Delete Successful', 'Success');
        return redirect()->route('stipend-records');
    }

    public function stipendRecordsView($id, $state)
    {
        $generalSetting = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();
        $invoiceInfo = StipendPayment::find($id);
        $date = StudentScholarship::where('student_id', $invoiceInfo->student_id)->first();
        
        $banks = SmBankAccount::where('active_status', '=', 1)
            ->where('school_id', Auth::user()->school_id)
            ->get();
    
        
        $total_paid = $invoiceInfo->amount;
        $status_text = __('fees.unpaid');
    
        if ($total_paid >= $invoiceInfo->stipends_amount) {
            $status_text = __('fees.paid');
        } elseif ($total_paid > 0 && $total_paid < $invoiceInfo->stipends_amount) {
            $status_text = __('fees.partial');
        }
        $invoiceDetails = StudentScholarship::where('student_id', $invoiceInfo->student_id)->get();
        
        if ($state == 'view') {
            return view('scholarship.stipend_records_view', compact('generalSetting', 'invoiceInfo', 'banks', 'date','status_text','invoiceDetails'));
        } else {
            return view('scholarship.stipend_records_print', compact('generalSetting', 'invoiceInfo', 'banks', 'date','status_text','invoiceDetails'));
        }
    }
    
}
