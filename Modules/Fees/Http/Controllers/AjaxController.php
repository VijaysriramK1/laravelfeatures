<?php

namespace Modules\Fees\Http\Controllers;

use App\Http\Controllers\Admin\StudentInfo\SmStudentReportController;
use App\Models\AdmissionFeesInvoice;
use App\Models\ScholarShips;
use App\SmSection;
use App\SmAddIncome;
use App\SmBankAccount;
use App\SmClassSection;
use App\SmAssignSubject;
use App\SmPaymentMethhod;
use Illuminate\Http\Request;
use App\Models\StudentRecord;
use App\Models\StudentScholarship;
use Illuminate\Routing\Controller;
use Modules\Fees\Entities\FmFeesType;
use Illuminate\Support\Facades\Artisan;
use Modules\Fees\Entities\FmFeesInvoice;
use App\Scopes\StatusAcademicSchoolScope;
use App\SmClass;
use App\SmStudent;
use App\SmStudentCategory;
use App\SmStudentGroup;
use Illuminate\Support\Facades\Auth;
use Modules\Fees\Entities\FmFeesTransaction;

class AjaxController extends Controller
{
    public function feesViewPayment(Request $request)
    {
        $feesinvoice = FmFeesInvoice::find($request->invoiceId);
        $feesTranscations = FmFeesTransaction::where('fees_invoice_id', $request->invoiceId)
            ->where('paid_status', 'approve')
            ->where('school_id', auth()->user()->school_id)
            ->get();
        $paymentMethods = SmPaymentMethhod::whereIn('method', ['Cash', 'Cheque', 'Bank'])->get();
        $banks = SmBankAccount::where('school_id', auth()->user()->school_id)->get();
        return view('fees::feesInvoice.viewPayment', compact('feesinvoice', 'feesTranscations', 'paymentMethods', 'banks'));
    }

    public function admissionfeesViewPayment(Request $request)
    {
        $feesinvoice = AdmissionFeesInvoice::find($request->invoiceId);
        $feesTranscations = FmFeesTransaction::where('admission_invoice_id', $request->invoiceId)
            ->where('paid_status', 'approve')
            ->where('school_id', auth()->user()->school_id)
            ->get();
        $row = AdmissionFeesInvoice::with('studentInfo')
            ->select('admission_fees_invoices.*')
            ->where('school_id', Auth::user()->school_id)
            ->where('academic_id', getAcademicId())
            ->orderBy('create_date', 'DESC');
        $paymentMethods = SmPaymentMethhod::whereIn('method', ['Cash', 'Cheque', 'Bank'])->get();
        $banks = SmBankAccount::where('school_id', auth()->user()->school_id)->get();
        return view('fees::feesInvoice.admissionViewPayment', compact('row', 'feesinvoice', 'feesTranscations', 'paymentMethods', 'banks'));
    }

    public function ajaxSelectStudent(Request $request)
    {
        try {
            $allStudents = StudentRecord::with('studentDetail', 'section')
                ->where('class_id', $request->classId)
                ->where('school_id', auth()->user()->school_id)
                ->where('academic_id', getAcademicId())
                ->get();
            return response()->json([$allStudents]);
        } catch (\Exception $e) {
            return response()->json("", 404);
        }
    }

    public function ajaxSelectFeesType(Request $request)
    {

        try {
            $type = substr($request->type, 0, 3);
            $editData = $request->editData;


            if ($type == "grp") {
                $groupId = substr($request->type, 3);
                $feesGroups = FmFeesType::where('fees_group_id', $groupId)
                    ->where('type', 'fees')
                    ->get();
                return view('fees::_allFeesType', compact('feesGroups', 'editData'));
            } else {
                $typeId = substr($request->type, 3);
                $feesType = FmFeesType::where('id', $typeId)
                    ->where('type', 'fees')
                    ->first();


                $amount = null;
                if (!empty($request->student_id)) {
                    $scholarship = StudentScholarship::where('student_id', $request->student_id)->first();

                    if ($scholarship) {
                        $scholarshipDetails = ScholarShips::where('id', $scholarship->scholarship_id)->first();
                        if ($scholarshipDetails) {

                            switch ($scholarshipDetails->coverage_type) {
                                case 'full':
                                    $amount = $scholarship->amount;
                                    break;

                                case 'percentage':
                                    $amount = ($scholarshipDetails->coverage_amount / 100) * $scholarship->amount;
                                    break;

                                case 'fixed':
                                    $amount = $scholarshipDetails->coverage_amount;
                                    break;
                            }
                        }
                    }
                }


                return view('fees::_allFeesType', compact('feesType', 'editData', 'amount'));
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }


    public function ajaxGetAllSection(Request $request)
    {
        try {
            if (teacherAccess()) {
                $sectionIds = SmAssignSubject::where('class_id', '=', $request->class_id)
                    ->where('teacher_id', auth()->user()->staff->id)
                    ->where('school_id', auth()->user()->school_id)
                    ->where('academic_id', getAcademicId())
                    ->distinct(['class_id', 'section_id'])
                    ->withoutGlobalScope(StatusAcademicSchoolScope::class)
                    ->get();
            } else {
                $sectionIds = SmClassSection::where('class_id', '=', $request->class_id)
                    ->where('school_id', auth()->user()->school_id)
                    ->withoutGlobalScope(StatusAcademicSchoolScope::class)
                    ->get();
            }
            $promote_sections = [];
            foreach ($sectionIds as $sectionId) {
                $promote_sections[] = SmSection::where('id', $sectionId->section_id)
                    ->withoutGlobalScope(StatusAcademicSchoolScope::class)
                    ->first(['id', 'section_name']);
            }
            return response()->json([$promote_sections]);
        } catch (\Exception $e) {
            return response()->json("", 404);
        }
    }

    public function ajaxSectionAllStudent(Request $request)
    {
        try {
            $allStudents = StudentRecord::with('studentDetail', 'section')
                ->where('class_id', $request->class_id)
                ->where('section_id', $request->section_id)
                ->where('school_id', auth()->user()->school_id)
                ->where('student_group_id', $request->student_group_id)
                ->where('academic_id', getAcademicId())
                ->get();
            return response()->json([$allStudents]);
        } catch (\Exception $e) {
            return response()->json("", 404);
        }
    }
    public function fetchStudents(Request $request)
    {
        $groupId = $request->input('group_id');
        $studentId = StudentRecord::where('group_id', $groupId)->pluck('student_id');
        $students = SmStudent::whereIn('id', $studentId)->get();
        return response()->json(['students' => $students]);
    }


    public function fetchcategoryStudents(Request $request)
    {

        $categorygroupId = $request->input('student_category_id');

        $studentId = StudentRecord::where('student_category_id', $categorygroupId)->pluck('student_id');

        $students = SmStudent::whereIn('id', $studentId)->get();

        return response()->json(['students' => $students]);
    }



    public function getStudentsByClassAndGroup(Request $request)
    {
        if ($request->parent) {
            $class = SmClass::withoutGlobalScope(GlobalAcademicScope::class)->withoutGlobalScope(StatusAcademicSchoolScope::class)->where('school_id', Auth::user()->school_id)->with('groupclassSections')->whereNULL('parent_id')->where('id', $request->id)->first();
            $sectionIds = SmClassSection::where('class_id', '=', $request->id)
                ->where('school_id', Auth::user()->school_id)->get();
            $promote_sections = [];
            foreach ($sectionIds as $sectionId) {
                $promote_sections[] = SmSection::where('id', $sectionId->section_id)->withoutGlobalScope(StatusAcademicSchoolScope::class)->withoutGlobalScope(GlobalAcademicScope::class)->whereNull('parent_id')->first(['id', 'section_name']);
            }
        } else {
            $class = SmClass::find($request->id);
            if (teacherAccess()) {
                $sectionIds = SmAssignSubject::where('class_id', '=', $request->id)
                    ->where('teacher_id', Auth::user()->staff->id)
                    ->where('school_id', Auth::user()->school_id)
                    ->where('academic_id', getAcademicId())
                    ->select('class_id', 'section_id')
                    ->distinct(['class_id', 'section_id'])
                    ->withoutGlobalScope(StatusAcademicSchoolScope::class)
                    ->get();
            } else {
                $sectionIds = SmClassSection::where('class_id', $request->id)
                    ->withoutGlobalScope(StatusAcademicSchoolScope::class)->get();
            }

            $promote_sections = [];
            foreach ($sectionIds as $sectionId) {
                $promote_sections[] = SmSection::where('id', $sectionId->section_id)->withoutGlobalScope(StatusAcademicSchoolScope::class)->first(['id', 'section_name']);
            }
        }


        return response()->json([$promote_sections]);
    }

    public function getClassGroups(Request $request)
    {
        $classId = $request->input('class_id');
        $groups = SmStudentGroup::where('class_id', $classId)->get();
        return response()->json($groups);
    }


    public function ajaxGetAllStudent(Request $request)
    {
        try {
            $allStudents = StudentRecord::with('studentDetail', 'section')
                ->where('class_id', $request->class_id)
                ->where('school_id', auth()->user()->school_id)
                ->where('academic_id', getAcademicId())
                ->get();
            return response()->json([$allStudents]);
        } catch (\Exception $e) {
            return response()->json("", 404);
        }
    }

    public function changeMethod(Request $request)
    {
        try {
            $transcation = FmFeesTransaction::find($request->feesInvoiceId);
            $transcation->payment_method = $request->change_method;
            $transcation->update();

            $payment_method = SmPaymentMethhod::where('method', $request->change_method)->first();

            $incomes = SmAddIncome::where('fees_collection_id', $request->feesInvoiceId)->get();

            foreach ($incomes as $income) {
                $updateIncome = SmAddIncome::find($income->id);
                $updateIncome->payment_method = $payment_method->id;
                $updateIncome->update();
            }
            return response()->json(['sucess']);
        } catch (\Exception $e) {
            return response()->json('Error', $e->getMessage());
        }
    }

    public function admissionchangeMethod(Request $request)
    {
        try {
            $transcation = FmFeesTransaction::find($request->feesInvoiceId);
            $transcation->payment_method = $request->change_method;
            $transcation->update();

            $payment_method = SmPaymentMethhod::where('method', $request->change_method)->first();

            $incomes = SmAddIncome::where('fees_collection_id', $request->feesInvoiceId)->get();

            foreach ($incomes as $income) {
                $updateIncome = SmAddIncome::find($income->id);
                $updateIncome->payment_method = $payment_method->id;
                $updateIncome->update();
            }
            return response()->json(['sucess']);
        } catch (\Exception $e) {
            return response()->json('Error', $e->getMessage());
        }
    }

    public function serviceCharge(Request $request)
    {
        $service_charge = serviceCharge($request->gateway);
        $service_charge_amount =  number_format(chargeAmount($request->gateway, $request->amount), 2, '.', '');

        return response()->json([
            'service_charge' => $service_charge,
            'service_charge_amount' => $service_charge_amount,
        ]);
    }
    public function migration()
    {
        Artisan::call('migrate');
        return "Sucess";
    }
    public function sectionToGroup(Request $request)
    {
        $sectionIds = StudentRecord::where('section_id', $request->id)->pluck('group_id');

        $groups = SmStudentGroup::whereIn('id', $sectionIds)->get();

        return response()->json(['groups' => $groups]);
    }
    
    public function groupToCategory(Request $request)
    {
        $categoryIds = StudentRecord::where('group_id', $request->id)->pluck('student_category_id');
    
        $categories = SmStudentCategory::whereIn('id', $categoryIds)->get();
    
        return response()->json(['categories' => $categories]);
    }
    
}
