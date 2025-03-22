<?php

namespace App\Http\Controllers\Student;

use App\SmClass;
use App\SmStudent;
use Carbon\Carbon;
use App\SmClassSection;
use Illuminate\Http\Request;
use App\Models\StudentRecord;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function studentClassList()
    {
        $get_classes = SmClass::where('active_status', 1)->where('school_id', Auth::user()->school_id)->orderby("id", "asc")->get();
        return response()->json($get_classes);
    }

    public function studentClassWiseSectionList(Request $request)
    {
        $get_sections = SmClassSection::with('sectionname')->where('class_id', $request->class_id)->where('school_id', Auth::user()->school_id)->orderby("id", "asc")->get();
        return response()->json($get_sections);
    }

    public function unApprovedStudentDetails(Request $request)
    {
        if ($request->ajax()) {
            if ($request->class_id != '' && $request->section_id != '') {
                $check_student_record = StudentRecord::where('class_id', $request->class_id)->where('section_id', $request->section_id)->where('school_id', Auth::user()->school_id)->pluck('student_id');
                $data = SmStudent::where('active_status', 2)->where('school_id', Auth::user()->school_id)->whereIn('id', $check_student_record)->get();
            } else {
                $data = SmStudent::where('active_status', 2)->where('school_id', Auth::user()->school_id)->get();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('full_name', function ($row) {
                    return $row->first_name . ' ' . $row->last_name ?? '--';
                })
                ->addColumn('dob', function ($row) {
                    return Carbon::parse($row->date_of_birth)->format('d-m-Y') ?? '--';
                })
                ->addColumn('edit', function ($row) {
                    return '<a href="/student-edit/' . $row->id . '"><i class="bi bi-pencil"></i></a>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '
                    <p class="mt-2">
                    <a href="/student-edit/' . $row->id . '" class="viewclick" style="color: #7c32ff !important;"><i class="bi bi-eye-fill fs-6"></i></a>
                    <a href="/student-edit/' . $row->id . '" class="ms-1 editclick" style="color: #7c32ff !important;"><i class="bi bi-pencil-square"></i></a>
                    <a type="button" class="approvedstatus ms-0 pt-1" data-id="' . $row->id . '" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Approve" style="color: #7c32ff !important;"><i class="bi bi-check-lg fs-5"></i></a>
                    </p>';
                    return $btn;
                })
                ->with('status', 'success')
                ->make(true);
        }

        return abort(404);
    }

    public function studentStatusUpdate($id, $status)
    {
        try {
            if ($status == 'unapprovedstatus') {
                $status = 2;
                $message = 'Student moved to unapproved list';
                $notificationMessage = 'Your account status has been changed to unapproved';
            } else if ($status == 'approvedstatus') {
                $status = 1;
                $message = 'Student successfully approved';
                $notificationMessage = 'Your account has been approved';
            } else {
                return response()->json(['status' => 'error', 'message' => 'Invalid status']);
            }

            $student = SmStudent::with('parents')->find($id);
            if (!$student) {
                return response()->json(['status' => 'error', 'message' => 'Student not found']);
            }

            $student->active_status = $status;
            $student->save();

            sendNotification($notificationMessage, null, $student->user_id, 2);

            if ($student->parents) {
                sendNotification($notificationMessage, null, $student->parents->user_id, 3);
            }

            sendNotification("Student Approved", '/student-edit/' . $student->id, 1, 1);

            return response()->json(['status' => 'success', 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Operation Failed']);
        }
    }

    public function studentInvoiceDetails($id)
    {
        $checkInvoiceInfo = DB::table('admission_fees_invoices')->where('id', $id)->first();

        if (!empty($checkInvoiceInfo)) {
            $invoiceInfo = $checkInvoiceInfo;
            $invoiceDetails = DB::table('admission_fees_invoice_chields')
                ->where('admission_fees_invoice_id', $checkInvoiceInfo->id)
                ->first();

            $studentDetails = DB::table('sm_admission_queries')->select('sm_admission_queries.name', 'sm_admission_queries.phone', 'sm_admission_queries.email', 'sm_admission_queries.address', 'sm_admission_queries.school_id', 'sm_classes.class_name')->leftJoin('sm_classes', 'sm_classes.id', '=', 'sm_admission_queries.class')->where('sm_admission_queries.id', $checkInvoiceInfo->student_id)->first();
            $generalSetting = DB::table('sm_general_settings')->where('id', $studentDetails->school_id)->first();
        } else {
            $invoiceInfo = '';
            $invoiceDetails = '';
            $studentDetails = '';
            $generalSetting = '';
        }
        return view('backEnd.studentInformation.student_fees_details', compact('invoiceInfo', 'invoiceDetails', 'studentDetails', 'generalSetting'));
    }
}
