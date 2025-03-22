<?php

namespace App\Http\Controllers\Student;

use App\SmStaff;
use App\SmClass;
use Carbon\Carbon;
use App\SmStudent;
use App\SmClassTeacher;
use App\SmClassSection;
use Illuminate\Http\Request;
use App\SmStudentAttendance;
use App\Models\StudentRecord;
use App\SmAssignClassTeacher;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\SmStudentAttendanceRequest;

class AttendanceController extends Controller
{
    public function attendancePage()
    {
       if (Auth::user()->role_id == 4) {
            $blade_file_name = 'attendances.teacher_student_attendance';
        } else {
            $blade_file_name = 'attendances.admin_student_attendance';
        }

        return view($blade_file_name);
    }


    public function attendanceClassList()
    {
        if (Auth::user()->role_id == 4) {
            $check_staff_details = SmStaff::where('user_id', Auth::user()->id)->where('school_id', Auth::user()->school_id)->first();
            $get_staff_assigned_classes = SmClassTeacher::where('teacher_id', $check_staff_details->id)->where('school_id', Auth::user()->school_id)->pluck('assign_class_teacher_id');
            $get_classes = SmAssignClassTeacher::with('class')->where('school_id', Auth::user()->school_id)->whereIn('id', $get_staff_assigned_classes)->groupBy('class_id')->orderBy('class_id', 'asc')->get();
        } else {
            $get_classes = SmClass::where('school_id', Auth::user()->school_id)->where('active_status', 1)->orderby("id", "asc")->get();
        }

        return response()->json($get_classes);
    }

    public function attendanceSectionList(Request $request)
    {
        if (Auth::user()->role_id == 4) {
            $check_staff_details = SmStaff::where('user_id', Auth::user()->id)->where('school_id', Auth::user()->school_id)->first();
            $get_staff_assigned_classes_sections = SmClassTeacher::where('teacher_id', $check_staff_details->id)->where('school_id', Auth::user()->school_id)->pluck('assign_class_teacher_id');
            $get_sections = SmAssignClassTeacher::with('section')->where('class_id', $request->class_id)->where('school_id', Auth::user()->school_id)->whereIn('id', $get_staff_assigned_classes_sections)->orderBy('class_id', 'asc')->orderBy('section_id', 'asc')->get();
        } else {
            $get_sections = SmClassSection::with('sectionname')->where('class_id', $request->class_id)->where('school_id', Auth::user()->school_id)->orderby("id", "asc")->get();
        }

        return response()->json($get_sections);
    }

    public function adminAttendanceSearch(Request $request)
    {
        if ($request->ajax()) {
            $check_student_attendance_record = SmStudentAttendance::with('studentInfo')->where('class_id', $request->class_id)->where('section_id', $request->section_id)->where('attendance_date', Carbon::parse($request->attendance_date)->format('Y-m-d'))->where('school_id', Auth::user()->school_id)->get();
            $get_student_record = StudentRecord::with('student')->where('class_id', $request->class_id)->where('section_id', $request->section_id)->where('school_id', Auth::user()->school_id)->get();

            if ($check_student_attendance_record->isEmpty()) {
                return Datatables::of($get_student_record)
                    ->addIndexColumn()
                    ->addColumn('admission_no', function ($row) {
                        return $row->student->admission_no ?? '--';
                    })
                    ->addColumn('student_name', function ($row) {
                        $get_first_name = $row->student->first_name ?? '';
                        $get_last_name = $row->student->last_name ?? '--';
                        return '<div>
                            <input type="hidden" value="' . $row->student_id . '" id="' . $row->student_id . '" /> 
                            <span>' . $get_first_name . ' ' . $get_last_name . '</span>
                            </div>';
                    })
                    ->addColumn('roll_number', function ($row) {
                        return $row->student->roll_no ?? '--';
                    })
                    ->addColumn('attendance', function ($row) {
                        return '<div class="d-flex radio-btn-flex">
                                <div class="mr-20">
                                <input type="radio" class="radio-btn-cls" value="P" id="present_' . $row->student_id . '" name="attendance_' . $row->student_id . '">
                                <label for="present_' . $row->student_id . '">Present</label>
                                </div>

                                <div class="mr-20">
                                <input type="radio" class="radio-btn-cls" value="L" id="late_' . $row->student_id . '" name="attendance_' . $row->student_id . '">
                                <label for="late_' . $row->student_id . '">Late</label>
                                </div>

                                <div class="mr-20">
                                <input type="radio" class="radio-btn-cls" value="A" id="absent_' . $row->student_id . '" name="attendance_' . $row->student_id . '">
                                <label for="absent_' . $row->student_id . '">Absent</label>
                                </div>

                                <div class="mr-20">
                                <input type="radio" class="radio-btn-cls" value="F" id="halfday_' . $row->student_id . '" name="attendance_' . $row->student_id . '">
                                <label for="halfday_' . $row->student_id . '">Half Day</label>
                                </div>
                            </div>';
                    })
                    ->rawColumns(['student_name', 'attendance'])
                    ->with('status', 'success')
                    ->make(true);
            } else if ($check_student_attendance_record->isNotEmpty() && $get_student_record->isNotEmpty()) {
                $get_combine_records = $check_student_attendance_record->map(function ($values_1) {
                    return (object)[
                        'student_id' => $values_1->student_id,
                        'admission_no' => $values_1->studentInfo->admission_no,
                        'student_name' => $values_1->studentInfo->first_name . ' ' . $values_1->studentInfo->last_name,
                        'roll_number' => $values_1->studentInfo->roll_no,
                        'attendance_type' => $values_1->attendance_type
                    ];
                })->concat($get_student_record->map(function ($values_2) {
                    return (object)[
                        'student_id' => $values_2->student_id,
                        'admission_no' => $values_2->student->admission_no,
                        'student_name' => $values_2->student->first_name . ' ' . $values_2->student->last_name,
                        'roll_number' => $values_2->student->roll_no,
                        'attendance_type' => null
                    ];
                }));

                $get_unique_records = $get_combine_records->unique('student_id')->values();

                return Datatables::of($get_unique_records)
                    ->addIndexColumn()
                    ->addColumn('admission_no', function ($row) {
                        return $row->admission_no ?? '--';
                    })
                    ->addColumn('student_name', function ($row) {
                        return '<div>
                    <input type="hidden" value="' . $row->student_id . '" id="' . $row->student_id . '" /> 
                    <span>' . $row->student_name ?? '--' . '</span>
                    </div>';
                    })
                    ->addColumn('roll_number', function ($row) {
                        return $row->roll_number ?? '--';
                    })
                    ->addColumn('attendance', function ($row) {
                        return '<div class="d-flex radio-btn-flex">
                        <div class="mr-20">
                        <input type="radio" class="radio-btn-cls" value="P" id="present_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'P' ? 'checked' : '') . '>
                        <label for="present_' . $row->student_id . '">Present</label>
                        </div>

                        <div class="mr-20">
                        <input type="radio" class="radio-btn-cls" value="L" id="late_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'L' ? 'checked' : '') . '>
                        <label for="late_' . $row->student_id . '">Late</label>
                        </div>

                        <div class="mr-20">
                        <input type="radio" class="radio-btn-cls" value="A" id="absent_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'A' ? 'checked' : '') . '>
                        <label for="absent_' . $row->student_id . '">Absent</label>
                        </div>

                        <div class="mr-20">
                        <input type="radio" class="radio-btn-cls" value="F" id="halfday_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'F' ? 'checked' : '') . '>
                        <label for="halfday_' . $row->student_id . '">Half Day</label>
                        </div>
                    </div>';
                    })
                    ->rawColumns(['student_name', 'attendance'])
                    ->with('status', 'success')
                    ->make(true);
            } else {
            }
        }

        return abort(404);
    }


    public function staffAttendanceSearch(Request $request)
    {
        if ($request->ajax()) {
            $class_id = $request->class_id;
            $section_id = $request->section_id;
            $current_date = Carbon::now()->format('Y-m-d');
            $attendance_date = Carbon::parse($request->attendance_date)->format('Y-m-d');
            $get_student_record = StudentRecord::with('student')->where('class_id', $class_id)->where('section_id', $section_id)->where('school_id', Auth::user()->school_id)->get();
            $check_student_attendance_record = SmStudentAttendance::with('studentInfo')->where('class_id', $class_id)->where('section_id', $section_id)->where('attendance_date', $attendance_date)->where('school_id', Auth::user()->school_id)->get();

            if ($check_student_attendance_record->isEmpty()) {
                return Datatables::of($get_student_record)
                    ->addIndexColumn()
                    ->addColumn('admission_no', function ($row) {
                        return $row->student->admission_no ?? '--';
                    })
                    ->addColumn('student_name', function ($row) {
                        $get_first_name = $row->student->first_name ?? '';
                        $get_last_name = $row->student->last_name ?? '--';
                        return '<div>
                        <input type="hidden" value="' . $row->student_id . '" id="' . $row->student_id . '" /> 
                        <span>' . $get_first_name . ' ' . $get_last_name . '</span>
                        </div>';
                    })
                    ->addColumn('roll_number', function ($row) {
                        return $row->student->roll_no ?? '--';
                    })
                    ->addColumn('attendance', function ($row) use ($class_id, $section_id, $current_date, $attendance_date) {

                        if ($current_date == $attendance_date) {
                            return '<div class="d-flex radio-btn-flex">
                                   <div class="mr-20">
                                     <input type="radio" class="radio-btn-cls" value="P" id="present_' . $row->student_id . '" name="attendance_' . $row->student_id . '">
                                      <label for="present_' . $row->student_id . '">Present</label>
                                    </div>
                            
                                     <div class="mr-20">
                                       <input type="radio" class="radio-btn-cls" value="L" id="late_' . $row->student_id . '" name="attendance_' . $row->student_id . '">
                                         <label for="late_' . $row->student_id . '">Late</label>
                                     </div>
                            
                                     <div class="mr-20">
                                       <input type="radio" class="radio-btn-cls" value="A" id="absent_' . $row->student_id . '" name="attendance_' . $row->student_id . '">
                                        <label for="absent_' . $row->student_id . '">Absent</label>
                                     </div>

                                     <div class="mr-20">
                                      <input type="radio" class="radio-btn-cls" value="F" id="halfday_' . $row->student_id . '" name="attendance_' . $row->student_id . '">
                                       <label for="halfday_' . $row->student_id . '">Half Day</label>
                                     </div>
                                    </div>';
                        } else {
                            $check_staff_details = SmStaff::where('user_id', Auth::user()->id)->where('school_id', Auth::user()->school_id)->first();
                            $check_request = SmStudentAttendanceRequest::where('staff_id', $check_staff_details->id)->where('class_id', $class_id)->where('section_id', $section_id)->where('attendance_date', $attendance_date)->first();

                            if (!empty($check_request)) {
                                if ($check_request->request_status == 'approve') {
                                    return '<div class="d-flex radio-btn-flex">
                                       <div class="mr-20">
                                         <input type="radio" class="radio-btn-cls" value="P" id="present_' . $row->student_id . '" name="attendance_' . $row->student_id . '">
                                         <label for="present_' . $row->student_id . '">Present</label>
                                       </div>
                                
                                       <div class="mr-20">
                                         <input type="radio" class="radio-btn-cls" value="L" id="late_' . $row->student_id . '" name="attendance_' . $row->student_id . '">
                                         <label for="late_' . $row->student_id . '">Late</label>
                                        </div>
                                
                                        <div class="mr-20">
                                          <input type="radio" class="radio-btn-cls" value="A" id="absent_' . $row->student_id . '" name="attendance_' . $row->student_id . '">
                                          <label for="absent_' . $row->student_id . '">Absent</label>
                                        </div>
    
                                        <div class="mr-20">
                                           <input type="radio" class="radio-btn-cls" value="F" id="halfday_' . $row->student_id . '" name="attendance_' . $row->student_id . '">
                                           <label for="halfday_' . $row->student_id . '">Half Day</label>
                                        </div>
                                       </div>';
                                } else if ($check_request->request_status == 'disapprove') {
                                    return '<div class="d-flex radio-btn-flex">
                                          <div class="mr-20">
                                           <input type="radio" class="radio-btn-cls" value="P" id="present_' . $row->student_id . '" name="attendance_' . $row->student_id . '" disabled>
                                           <label for="present_' . $row->student_id . '">Present</label>
                                          </div>
                                
                                          <div class="mr-20">
                                           <input type="radio" class="radio-btn-cls" value="L" id="late_' . $row->student_id . '" name="attendance_' . $row->student_id . '" disabled>
                                           <label for="late_' . $row->student_id . '">Late</label>
                                           </div>
                                
                                           <div class="mr-20">
                                             <input type="radio" class="radio-btn-cls" value="A" id="absent_' . $row->student_id . '" name="attendance_' . $row->student_id . '" disabled>
                                             <label for="absent_' . $row->student_id . '">Absent</label>
                                            </div>
    
                                            <div class="mr-20">
                                             <input type="radio" class="radio-btn-cls" value="F" id="halfday_' . $row->student_id . '" name="attendance_' . $row->student_id . '" disabled>
                                             <label for="halfday_' . $row->student_id . '">Half Day</label>
                                            </div>
                                           </div>';
                                } else {
                                }
                            } else {
                                return '<div class="d-flex radio-btn-flex">
                                             <div class="mr-20">
                                               <input type="radio" class="radio-btn-cls" value="P" id="present_' . $row->student_id . '" name="attendance_' . $row->student_id . '" disabled>
                                                <label for="present_' . $row->student_id . '">Present</label>
                                             </div>
                                
                                             <div class="mr-20">
                                              <input type="radio" class="radio-btn-cls" value="L" id="late_' . $row->student_id . '" name="attendance_' . $row->student_id . '" disabled>
                                              <label for="late_' . $row->student_id . '">Late</label>
                                             </div>
                                
                                             <div class="mr-20">
                                              <input type="radio" class="radio-btn-cls" value="A" id="absent_' . $row->student_id . '" name="attendance_' . $row->student_id . '" disabled>
                                              <label for="absent_' . $row->student_id . '">Absent</label>
                                             </div>
    
                                             <div class="mr-20">
                                               <input type="radio" class="radio-btn-cls" value="F" id="halfday_' . $row->student_id . '" name="attendance_' . $row->student_id . '" disabled>
                                                <label for="halfday_' . $row->student_id . '">Half Day</label>
                                             </div>
                                           </div>';
                            }
                        }
                    })
                    ->rawColumns(['student_name', 'attendance'])
                    ->with('status', 'success')
                    ->make(true);
            } else if ($check_student_attendance_record->isNotEmpty() && $get_student_record->isNotEmpty()) {

                $get_combine_records = $check_student_attendance_record->map(function ($values_1) {
                    return (object)[
                        'student_id' => $values_1->student_id,
                        'admission_no' => $values_1->studentInfo->admission_no,
                        'student_name' => $values_1->studentInfo->first_name . ' ' . $values_1->studentInfo->last_name,
                        'roll_number' => $values_1->studentInfo->roll_no,
                        'attendance_type' => $values_1->attendance_type
                    ];
                })->concat($get_student_record->map(function ($values_2) {
                    return (object)[
                        'student_id' => $values_2->student_id,
                        'admission_no' => $values_2->student->admission_no,
                        'student_name' => $values_2->student->first_name . ' ' . $values_2->student->last_name,
                        'roll_number' => $values_2->student->roll_no,
                        'attendance_type' => null
                    ];
                }));

                $get_unique_records = $get_combine_records->unique('student_id')->values();
                return Datatables::of($get_unique_records)
                    ->addIndexColumn()
                    ->addColumn('admission_no', function ($row) {
                        return $row->admission_no ?? '--';
                    })
                    ->addColumn('student_name', function ($row) {
                        return '<div>
                    <input type="hidden" value="' . $row->student_id . '" id="' . $row->student_id . '" /> 
                    <span>' . $row->student_name ?? "--" . '</span>
                    </div>';
                    })
                    ->addColumn('roll_number', function ($row) {
                        return $row->roll_number ?? '--';
                    })
                    ->addColumn('attendance', function ($row) use ($class_id, $section_id, $current_date, $attendance_date) {

                        if ($current_date == $attendance_date) {
                            return '<div class="d-flex radio-btn-flex">
                                     <div class="mr-20">
                                       <input type="radio" class="radio-btn-cls" value="P" id="present_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'P' ? 'checked' : '') . '>
                                       <label for="present_' . $row->student_id . '">Present</label>
                                     </div>
                        
                                     <div class="mr-20">
                                       <input type="radio" class="radio-btn-cls" value="L" id="late_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'L' ? 'checked' : '') . '>
                                       <label for="late_' . $row->student_id . '">Late</label>
                                     </div>
                        
                                     <div class="mr-20">
                                      <input type="radio" class="radio-btn-cls" value="A" id="absent_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'A' ? 'checked' : '') . '>
                                      <label for="absent_' . $row->student_id . '">Absent</label>
                                     </div>

                                     <div class="mr-20">
                                      <input type="radio" class="radio-btn-cls" value="F" id="halfday_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'F' ? 'checked' : '') . '>
                                      <label for="halfday_' . $row->student_id . '">Half Day</label>
                                     </div>
                                    </div>';
                        } else {
                            $check_staff_details = SmStaff::where('user_id', Auth::user()->id)->where('school_id', Auth::user()->school_id)->first();
                            $check_request = SmStudentAttendanceRequest::where('staff_id', $check_staff_details->id)->where('class_id', $class_id)->where('section_id', $section_id)->where('attendance_date', $attendance_date)->first();
                            if (!empty($check_request)) {
                                if ($check_request->request_status == 'approve') {
                                    return '<div class="d-flex radio-btn-flex">
                                        <div class="mr-20">
                                         <input type="radio" class="radio-btn-cls" value="P" id="present_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'P' ? 'checked' : '') . '>
                                         <label for="present_' . $row->student_id . '">Present</label>
                                        </div>
                        
                                        <div class="mr-20">
                                         <input type="radio" class="radio-btn-cls" value="L" id="late_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'L' ? 'checked' : '') . '>
                                         <label for="late_' . $row->student_id . '">Late</label>
                                        </div>
                        
                                        <div class="mr-20">
                                         <input type="radio" class="radio-btn-cls" value="A" id="absent_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'A' ? 'checked' : '') . '>
                                         <label for="absent_' . $row->student_id . '">Absent</label>
                                        </div>

                                        <div class="mr-20">
                                         <input type="radio" class="radio-btn-cls" value="F" id="halfday_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'F' ? 'checked' : '') . '>
                                         <label for="halfday_' . $row->student_id . '">Half Day</label>
                                        </div>
                                       </div>';
                                } else if ($check_request->request_status == 'disapprove') {
                                    return '<div class="d-flex radio-btn-flex">
                                             <div class="mr-20">
                                              <input type="radio" value="P" id="present_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'P' ? 'checked' : '') . ' disabled>
                                              <label for="present_' . $row->student_id . '">Present</label>
                                             </div>
                        
                                             <div class="mr-20">
                                              <input type="radio" value="L" id="late_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'L' ? 'checked' : '') . ' disabled>
                                              <label for="late_' . $row->student_id . '">Late</label>
                                             </div>
                        
                                             <div class="mr-20">
                                              <input type="radio" value="A" id="absent_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'A' ? 'checked' : '') . ' disabled>
                                              <label for="absent_' . $row->student_id . '">Absent</label>
                                             </div>

                                             <div class="mr-20">
                                              <input type="radio" value="F" id="halfday_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'F' ? 'checked' : '') . ' disabled>
                                              <label for="halfday_' . $row->student_id . '">Half Day</label>
                                             </div>
                                            </div>';
                                } else {
                                }
                            } else {
                                return '<div class="d-flex radio-btn-flex">
                                         <div class="mr-20">
                                          <input type="radio" value="P" id="present_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'P' ? 'checked' : '') . ' disabled>
                                          <label for="present_' . $row->student_id . '">Present</label>
                                         </div>
                        
                                         <div class="mr-20">
                                          <input type="radio" value="L" id="late_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'L' ? 'checked' : '') . ' disabled>
                                          <label for="late_' . $row->student_id . '">Late</label>
                                         </div>
                        
                                         <div class="mr-20">
                                          <input type="radio" value="A" id="absent_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'A' ? 'checked' : '') . ' disabled>
                                          <label for="absent_' . $row->student_id . '">Absent</label>
                                         </div>

                                         <div class="mr-20">
                                          <input type="radio" value="F" id="halfday_' . $row->student_id . '" name="attendance_' . $row->student_id . '" ' . ($row->attendance_type == 'F' ? 'checked' : '') . ' disabled>
                                          <label for="halfday_' . $row->student_id . '">Half Day</label>
                                         </div>
                                        </div>';
                            }
                        }
                    })
                    ->rawColumns(['student_name', 'attendance'])
                    ->with('status', 'success')
                    ->make(true);
            } else {
            }
        }
        return abort(404);
    }


    public function attendanceUpdate(Request $request)
    {
        foreach ($request->collect_details as $val) {
            SmStudentAttendance::updateOrCreate(
                [
                    'student_id' => $val['student_id'],
                    'class_id' => $request->class_id,
                    'section_id' => $request->section_id,
                    'attendance_date' => Carbon::parse($request->attendance_date)->format('Y-m-d'),
                    'school_id' => Auth::user()->school_id,
                ],
                [
                    'student_record_id' => $val['student_id'],
                    'attendance_type' => $val['attendance_type'],
                ]
            );
        }

        return response()->json(['status' => 'success', 'message' => 'Successfully attendance updated.']);
    }

    public function attendanceRequest(Request $request)
    {
        $check_staff_details = SmStaff::where('user_id', Auth::user()->id)->where('school_id', Auth::user()->school_id)->first();

        if (!empty($check_staff_details)) {
            $staff_id = $check_staff_details->id;
        } else {
            $staff_id = '';
        }

        SmStudentAttendanceRequest::where('staff_id', $staff_id)->where('class_id', $request->class_id)->where('section_id', $request->section_id)->where('attendance_date', Carbon::parse($request->attendance_date)->format('Y-m-d'))->delete();

        SmStudentAttendanceRequest::create([
            'request_notes' => $request->request_notes,
            'request_status' => 'disapprove',
            'attendance_date' => Carbon::parse($request->attendance_date)->format('Y-m-d'),
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'staff_id' => $staff_id
        ]);
        return response()->json(['status' => 'success', 'message' => 'Successfully attendance request sended.']);
    }


    public function attendanceStatus(Request $request)
    {
        $check_staff_details = SmStaff::where('user_id', Auth::user()->id)->where('school_id', Auth::user()->school_id)->first();

        if (!empty($check_staff_details)) {
            $staff_id = $check_staff_details->id;
        } else {
            $staff_id = '';
        }

        $check_details = SmStudentAttendanceRequest::where('staff_id', $staff_id)->where('class_id', $request->class_id)->where('section_id', $request->section_id)->where('attendance_date', Carbon::parse($request->attendance_date)->format('Y-m-d'))->first();

        if (!empty($check_details)) {
            $current_status = $check_details->request_status;
        } else {
            $current_status = '';
        }

        return response()->json(['status' => 'success', 'current_status' => $current_status]);
    }


    public function attendanceRequestPage()
    {
        $get_classwise_sections = SmStudentAttendanceRequest::with('class', 'section')->selectRaw('class_id, section_id, COUNT(*) as get_count')->groupBy('class_id', 'section_id')->orderBy('class_id', 'asc')->orderBy('section_id', 'asc')->get();
        return view('attendances.admin_student_attendance_request', compact('get_classwise_sections'));
    }

    public function classSectionWiseAttendanceRequestDetails(Request $request)
    {
        if ($request->ajax()) {
            if ($request->selected_class != '' && $request->selected_section != '') {
                $data = SmStudentAttendanceRequest::with('class', 'section', 'teacher')->where('class_id', $request->selected_class)->where('section_id', $request->selected_section)->get();
            } else {
                $get_first_data = SmStudentAttendanceRequest::orderBy('class_id', 'asc')->orderBy('section_id', 'asc')->first();
                $data = SmStudentAttendanceRequest::with('class', 'section', 'teacher')->where('class_id', $get_first_data->class_id)->where('section_id', $get_first_data->section_id)->get();
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('teacher_full_name', function ($row) {
                    return $row->teacher->first_name . ' ' . $row->teacher->last_name;
                })
                ->addColumn('class', function ($row) {
                    return $row->class->class_name ?? '--';
                })

                ->addColumn('section', function ($row) {
                    return $row->section->section_name ?? '--';
                })

                ->addColumn('attendance_date', function ($row) {
                    return Carbon::parse($row->attendance_date)->format('d-m-Y') ?? '--';
                })

                ->addColumn('status_update', function ($row) {
                    if ($row->request_status == 'approve') {
                        $btn = '<a type="button" class="danger-btn text-white disapprove-cls" data-id="' . $row->id . '" data-classid="' . $row->class_id . '" data-sectionid="' . $row->section_id . '">Reject</a>';
                    } else {
                        $btn = '<a type="button" class="primary-btn small fix-gr-bg approve-cls" data-id="' . $row->id . '" data-classid="' . $row->class_id . '" data-sectionid="' . $row->section_id . '">Approve</a>';
                    }
                    return $btn;
                })

                ->addColumn('action', function ($row) {
                    return '<a type="button" class="delete-cls text-danger" data-id="' . $row->id . '" data-classid="' . $row->class_id . '" data-sectionid="' . $row->section_id . '"><i class="bi bi-trash fs-5"></i></a>';
                })
                ->rawColumns(['status_update', 'action'])
                ->with('status', 'success')
                ->make(true);
        }

        return abort(404);
    }

    public function attendanceRequestUpdate(Request $request)
    {
        SmStudentAttendanceRequest::where('id', $request->id)->update(['request_status' => $request->type]);
        return response()->json(['status' => 'success', 'message' => 'Successfully status updated.']);
    }


    public function attendanceRequestDelete(Request $request)
    {
        SmStudentAttendanceRequest::where('id', $request->id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Successfully request deleted.']);
    }


    public function myAttendancePage()
    {
        $current_year = Carbon::now()->format('Y');
        
        for ($i = 0; $i <= 10; $i++) {
            $get_years[] = Carbon::create($current_year - $i)->format('Y');
        }

        return view('attendances.student_panel_attendance_report', compact('get_years'));
    }

    public function myAttendanceSearch(Request $request)
    {
        $check_student = SmStudent::where('user_id', Auth::user()->id)->where('school_id', Auth::user()->school_id)->first();
        $check_attendance = SmStudentAttendance::where('student_id', $check_student->id)->whereYear('attendance_date', $request->year)->whereMonth('attendance_date', $request->month)->get();

        if ($check_attendance->isEmpty()) {
            $content = '<section class="student-attendance">
                          <div class="container-fluid p-0">
                            <div class="row mt-40">
                              <div class="col-lg-12 student-details up_admin_visitor">
                                 <div class="white-box">
                                 <div class="tab-content mt-15">
                                   <div class="text-center mb-2">No attendance record found.</div>
                                 </div>
                              </div>
                            </div>
                          </div>
                        </div>
                       </section>';
        } else {
            $get_student_record = StudentRecord::with('class', 'section')->where('student_id', $check_student->id)->where('school_id', Auth::user()->school_id)->first();
            $student_class = $get_student_record->class->class_name ?? '';
            $student_section = $get_student_record->section->section_name ?? '';
            $present_count = $check_attendance->where('attendance_type', 'P')->count();
            $absent_count = $check_attendance->where('attendance_type', 'A')->count();
            $late_count = $check_attendance->where('attendance_type', 'L')->count();
            $half_day_count = $check_attendance->where('attendance_type', 'F')->count();
            $get_days = cal_days_in_month(CAL_GREGORIAN, $request->month, $request->year);
            
            for ($i = 1; $i <= $get_days; $i++) {
                    $thead_days = Carbon::createFromDate($request->year, $request->month, $i)->format('D');
                    $collect_thead_days[] = '<th width="3%">
                                              <span>' . $i . '</span>
                                              <span>' . $thead_days . '</span>
                                            </th>';
            }

            for ($i = 1; $i <= $get_days; $i++) {
                $tbody_days = $request->year . '-' . $request->month . '-' . $i;
                $check_date = $check_attendance->where('attendance_date', $tbody_days)->first();
                if (!empty($check_date)) {
                    $get_attendance_type = $check_date->attendance_type;
                } else {
                    $get_attendance_type = '-';
                }

                $collect_tbody_days[] = '<td>' . $get_attendance_type . '</td>';
            }
            
            $content = '<section class="student-attendance">

                <div class="container-fluid p-0">

                    <div class="row mt-40">
                        <div class="col-lg-12 student-details up_admin_visitor">
                            <div class="white-box">
                                <ul class="nav nav-tabs tabs_scroll_nav" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active"
                                                href="javascript:void(0);" role="tab"
                                                data-toggle="tab"><span>' . $student_class . '</span>
                                                <span>(</span> <span>' . $student_section . '</span> <span>)</span>
                                            </a>
                                        </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content mt-15">
                                        <div role="tabpanel" class="tab-pane fade active show">
                                            <div class="row">
                                                <div class="col-lg-12 d-flex justify-content-between">
                                                    <div class="lateday d-flex">
                                                        <div class="mr-3"><span>' . __("student.present") . '</span><span>:</span> <span
                                                                class="text-success">P</span></div>
                                                        <div class="mr-3"><span>' . __("student.late") . '</span><span>:</span> <span
                                                                class="text-warning">L</span></div>
                                                        <div class="mr-3"><span>' . __("student.absent") . '</span><span>:</span> <span
                                                                class="text-danger">A</span></div>
                                                        <div class="mr-3"><span>' . __("student.half_day") . '</span><span>:</span> <span
                                                                class="text-info">F</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">

                                                    <div>
                                                        <div class="table-responsive" style="padding-top:15px">

                                                            <table id="table_part" style="margin-bottom:25px"
                                                                class="table table-responsive" cellspacing="0"
                                                                width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="3%">P</th>
                                                                        <th width="3%">L</th>
                                                                        <th width="3%">A</th>
                                                                        <th width="3%">F</th>
                                                                        ' . implode('', $collect_thead_days) . '
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>' . $present_count . '</td>
                                                                        <td>' . $late_count . '</td>
                                                                        <td>' . $absent_count . '</td>
                                                                        <td>' . $half_day_count . '</td>
                                                                        ' . implode('', $collect_tbody_days) . '
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>';
        }
        
        return response()->json(['content' => $content]);
    }
}