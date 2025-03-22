<?php

namespace App\Http\Controllers\Student;

use File;
use App\User;
use App\SmBook;
use App\SmExam;
use ZipArchive;
use App\SmClass;
use App\SmEvent;
use App\SmRoute;
use App\SmStaff;
use App\SmParent;
use App\SmHoliday;
use App\SmSection;
use App\SmStudent;
use App\SmVehicle;
use App\SmWeekend;
use Carbon\Carbon;
use App\SmExamType;
use App\SmHomework;
use App\SmRoomList;
use App\SmRoomType;
use App\SmBaseSetup;
use App\SmBookIssue;
use App\SmClassTime;
use App\SmComplaint;
use App\SmLeaveType;
use App\SmMarksGrade;
use App\SmOnlineExam;
use App\ApiBaseMethod;
use App\SmBankAccount;
use App\SmLeaveDefine;
use App\SmNoticeBoard;
use App\SmAcademicYear;
use App\SmExamSchedule;
use App\SmLeaveRequest;
use App\SmNotification;
use App\SmStudentGroup;
use App\SmAssignSubject;
use App\SmAssignVehicle;
use App\SmDormitoryList;
use App\SmLibraryMember;
use Barryvdh\DomPDF\PDF;
use App\SmPaymentMethhod;
use App\SmGeneralSettings;
use App\SmStudentCategory;
use App\SmStudentDocument;
use App\SmStudentTimeline;
use App\SmStudentAttendance;
use App\SmSubjectAttendance;
use App\Traits\CustomFields;
use Illuminate\Http\Request;
use App\Models\SmCustomField;
use App\Models\StudentRecord;
use App\SmExamScheduleSubject;
use App\Models\AttendanceCode;
use App\SmClassOptionalSubject;
use App\SmTeacherUploadContent;
use App\SmOptionalSubjectAssign;
use App\SmStudentTakeOnlineExam;
use App\SmUploadHomeworkContent;
use App\Traits\NotificationSend;
use App\Models\SmCalendarSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\TeacherEvaluationSetting;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\SmStudentRegistrationField;
use Illuminate\Support\Facades\Notification;
use Modules\RolePermission\Entities\SmaRole;
use Modules\Wallet\Entities\WalletTransaction;
use App\Notifications\LeaveApprovedNotification;
use Modules\OnlineExam\Entities\SmaOnlineExam;
use Modules\University\Entities\UnAssignSubject;
use Modules\University\Entities\UnSemesterLabel;
use Modules\University\Entities\UniversitySetting;
use Modules\BehaviourRecords\Entities\AssignIncident;
use App\Http\Controllers\SmAcademicCalendarController;
use App\Notifications\StudentHomeworkSubmitNotification;
use Modules\BehaviourRecords\Entities\BehaviourRecordSetting;
use App\Http\Requests\Admin\StudentInfo\SmStudentAdmissionRequest;

class SmStudentPanelController extends Controller
{
    use NotificationSend;
    use CustomFields;
    public function studentMyAttendanceSearchAPI(Request $request, $id = null)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'month' => "required",
            'year' => "required",
        ]);

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $student_detail = SmStudent::where('user_id', $id)->first();

            $year = $request->year;
            $month = $request->month;
            if ($month < 10) {
                $month = '0' . $month;
            }
            $current_day = date('d');

            $days = cal_days_in_month(CAL_GREGORIAN, $month, $request->year);
            $days2 = '';
            if ($month != 1) {
                $days2 = cal_days_in_month(CAL_GREGORIAN, $month - 1, $request->year);
            } else {
                $days2 = cal_days_in_month(CAL_GREGORIAN, $month, $request->year);
            }
            // return  $days2;
            $previous_month = $month - 1;
            $previous_date = $year . '-' . $previous_month . '-' . $days2;
            $previousMonthDetails['date'] = $previous_date;
            $previousMonthDetails['day'] = $days2;
            $previousMonthDetails['week_name'] = date('D', strtotime($previous_date));
            $attendances = SmStudentAttendance::where('student_id', $student_detail->id)
                ->where('attendance_date', 'like', '%' . $request->year . '-' . $month . '%')
                ->select('attendance_type', 'attendance_date')
                ->where('school_id', Auth::user()->school_id)->get();

            return view('backEnd.studentPanel.student_attendance', compact('attendances', 'days', 'year', 'month', 'current_day'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    
    public function studentMyAttendancePrint($id, $month, $year)
    {
        try {
            $login_id = Auth::user()->id;
            $student_detail = SmStudent::where('user_id', $login_id)->first();
            $current_day = date('d');
            $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $attendances = SmStudentAttendance::where('student_record_id', $id)->where('student_id', $student_detail->id)->where('academic_id', getAcademicId())->where('attendance_date', 'like', $year . '-' . $month . '%')->where('school_id', Auth::user()->school_id)->get();
            $customPaper = array(0, 0, 700.00, 1000.80);
            return view('backEnd.studentPanel.my_attendance_print', compact('attendances', 'days', 'year', 'month', 'current_day', 'student_detail'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentProfile(Request $request, $id = null)
    {
            $student_detail = auth()->user()->student->load('studentRecords.class', 'studentDocument', 'academicYear', 'defaultClass.class', 'defaultClass.section', 'gender');
            $student = $student_detail;
            $bank_cheque_info = SmPaymentMethhod::where('school_id', Auth::user()->school_id)->get();
            $data['bank_info'] = $bank_cheque_info->where('method', 'Bank')->first();
            $data['cheque_info'] =  $bank_cheque_info->where('method', 'Cheque')->first();
            $records = $student_detail->studentRecords->load('directFeesInstallments.installment', 'directFeesInstallments.payments.user');

            $optional_subject_setup = SmClassOptionalSubject::where('class_id', '=', $student_detail->class_id)->first();

            $student_optional_subject = $student_detail->subjectAssign;

            $siblings = SmStudent::where('parent_id', $student_detail->parent_id)
                ->where('school_id', Auth::user()->school_id)->where('id', '!=', $student_detail->id)->whereNotNull('parent_id')
                ->get();

            $fees_assigneds = $student_detail->feesAssign;
            $fees_discounts = $student_detail->feesAssignDiscount;

            $documents = $student_detail->studentDocument;

            $timelines = SmStudentTimeline::where('staff_student_id', $student_detail->id)
                ->where('type', 'stu')
                ->where('visible_to_student', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $exams = SmExamSchedule::where('class_id', $student_detail->class_id)
                ->where('section_id', $student_detail->section_id)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $grades = SmMarksGrade::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $maxgpa = $grades->max('gpa');

            $failgpa = $grades->min('gpa');

            $failgpaname = $grades->where('gpa', $failgpa)->first();

            $exam_terms = SmExamType::with('examSettings')->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $leave_details = SmLeaveRequest::where('staff_id', Auth::user()->id)
                ->where('role_id', Auth::user()->role_id)
                ->where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $result_views = SmStudentTakeOnlineExam::where('active_status', 1)
                ->where('status', 2)
                ->where('academic_id', getAcademicId())
                ->where('student_id', @Auth::user()->student->id)
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $all_paymentMethods = SmPaymentMethhod::whereNotIn('method', ["Cash", "Wallet"])
                ->where('school_id', Auth::user()->school_id)
                ->get();
            $paymentMethods = $all_paymentMethods->whereNotIn('method', ["Cash", "Wallet"])->load('gatewayDetail');

            $bankAccounts = SmBankAccount::where('active_status', 1)
                ->where('school_id', Auth::user()->school_id)
                ->get();

            if (moduleStatusCheck('Wallet')) {
                $walletAmounts = WalletTransaction::where('user_id', Auth::user()->id)
                    ->where('school_id', Auth::user()->school_id)
                    ->get();
            } else {
                $walletAmounts = 0;
            }

            $custom_field_data = $student_detail->custom_field;

            if (!is_null($custom_field_data)) {
                $custom_field_values = json_decode($custom_field_data);
            } else {
                $custom_field_values = null;
            }

            $academic_year = $student_detail->academicYear;

            $custom_field_data = $student_detail->custom_field;

            if (!is_null($custom_field_data)) {
                $custom_field_values = json_decode($custom_field_data);
            } else {
                $custom_field_values = null;
            }
            $departmentSubjects = null;
            $next_subjects = null;
            $next_semester_label = null;
            $canChoose = false;
            $unSettings = null;
            if (moduleStatusCheck('University')) {
                $lastRecord = studentRecords(null, $student_detail->id)
                    ->where('is_default', 1)
                    ->orderBy('id', 'DESC')->first();
                $labelIds = StudentRecord::where('student_id', $student_detail->id)
                    ->where('school_id', auth()->user()->school_id)
                    ->pluck('un_semester_label_id')->toArray();
                $lastRecordCreatedDate = date('Y-m-d');
                if ($lastRecord) {
                    $next_semester_label = UnSemesterLabel::whereNotIn('id', $labelIds)
                        ->where('id', '!=', $lastRecord->un_semester_label_id)
                        ->first();

                    $next_subjects = UnAssignSubject::where('school_id', auth()->user()->school_id)
                        ->where('un_semester_label_id', $lastRecord->un_semester_label_id)
                        ->get();
                    $departmentSubjects = $lastRecord->withOutPreSubject;

                    $lastRecordCreatedDate = $student_detail->lastRecord->value('created_at')->format('Y-m-d');
                }

                $unSettings = UniversitySetting::where('school_id', auth()->user()->school_id)
                    ->first();



                if ($unSettings) {
                    if ($unSettings->choose_subject == 1) {
                        $endDate = Carbon::parse($lastRecordCreatedDate)->addDay($unSettings->end_day)->format('Y-m-d');
                        $now = Carbon::now()->format('Y-m-d');
                        if ($now <= $endDate) {
                            $canChoose = true;
                        }
                    }
                }
            }
            $payment_gateway = $all_paymentMethods->first();

            $now = Carbon::now();
            $year = $now->year;
            $month  = $now->month;
            $days = cal_days_in_month(CAL_GREGORIAN, $now->month, $now->year);
            $studentRecord = StudentRecord::where('student_id', $student_detail->id)
                ->where('academic_id', getAcademicId())
                ->where('school_id', $student_detail->school_id)
                ->get();

            $attendance = SmStudentAttendance::where('student_id', $student_detail->id)
                ->whereIn('academic_id', $studentRecord->pluck('academic_id'))
                ->whereIn('student_record_id', $studentRecord->pluck('id'))
                ->get();

            $subjectAttendance = SmSubjectAttendance::with('student')
                ->whereIn('academic_id', $studentRecord->pluck('academic_id'))
                ->whereIn('student_record_id', $studentRecord->pluck('id'))
                ->where('school_id', $student_detail->school_id)
                ->get();

            $studentBehaviourRecords = (moduleStatusCheck('BehaviourRecords')) ? AssignIncident::where('student_id', auth()->user()->student->id)->with('incident', 'user', 'academicYear')->get() : null;
            $behaviourRecordSetting = BehaviourRecordSetting::where('id', 1)->first();

            if (moduleStatusCheck('University')) {
                $student_id = $student_detail->id;
                $studentDetails = SmStudent::find($student_id);
                $studentRecordDetails = StudentRecord::where('student_id', $student_id);
                $studentRecords = $studentRecordDetails->distinct('un_academic_id')->get();
                $print = 1;
                return view(
                    'backEnd.studentPanel.my_profile',
                    compact('next_subjects', 'unSettings', 'departmentSubjects', 'next_semester_label', 'canChoose', 'academic_year', 'student_detail', 'fees_assigneds', 'fees_discounts', 'exams', 'documents', 'timelines', 'siblings', 'grades', 'exam_terms', 'result_views', 'leave_details', 'optional_subject_setup', 'student_optional_subject', 'maxgpa', 'failgpaname', 'custom_field_values', 'paymentMethods', 'walletAmounts', 'bankAccounts', 'records', 'studentDetails', 'studentRecordDetails', 'studentRecords', 'print', 'payment_gateway', 'student', 'data', 'studentBehaviourRecords', 'behaviourRecordSetting')
                );
            } else {
                return view(
                    'backEnd.studentPanel.my_profile',
                    compact('next_subjects', 'unSettings', 'departmentSubjects', 'next_semester_label', 'canChoose', 'academic_year', 'student_detail', 'fees_assigneds', 'fees_discounts', 'exams', 'documents', 'timelines', 'siblings', 'grades', 'exam_terms', 'result_views', 'leave_details', 'optional_subject_setup', 'student_optional_subject', 'maxgpa', 'failgpaname', 'custom_field_values', 'paymentMethods', 'walletAmounts', 'bankAccounts', 'records', 'payment_gateway', 'student', 'data', 'attendance', 'subjectAttendance', 'days', 'year', 'month', 'studentBehaviourRecords', 'behaviourRecordSetting')
                );
            }
    }

    public function studentUpdate(SmStudentAdmissionRequest $request)
    {
        try {
            $student_detail = SmStudent::find($request->id);
            $validator = Validator::make($request->all(), $this->generateValidateRules("student_registration", $student_detail));
            if ($validator->fails()) {
                $errors = $validator->errors();
                foreach ($errors->all() as $error) {
                    Toastr::error(str_replace('custom f.', '', $error), 'Failed');
                }
                return redirect()->back()->withInput();
            }
            // custom field validation End


            $destination = 'public/uploads/student/document/';
            $student_file_destination = 'public/uploads/student/';
            $student = SmStudent::find($request->id);

            $academic_year = $request->session ? SmAcademicYear::find($request->session) : '';
            DB::beginTransaction();

            if ($student) {
                $username = $request->phone_number ? $request->phone_number : $request->admission_number;
                $phone_number = $request->phone_number ? $request->phone_number : null;
                $user_stu = $this->addUser($student_detail->user_id, 2, $username, $request->email_address, $phone_number);
                //sibling || parent info user update
                if (($request->sibling_id == 0 || $request->sibling_id == 1) && $request->parent_id == "") {
                    $username = $request->guardians_phone ? $request->guardians_phone : $request->guardians_email;
                    $phone_number = $request->guardians_phone;
                    $user_parent =  $this->addUser($student_detail->parents->user_id, 3, $username, $request->guardians_email, $phone_number);

                    $user_parent->toArray();
                } elseif ($request->sibling_id == 0 && $request->parent_id != "") {
                    User::destroy($student_detail->parents->user_id);
                } elseif (($request->sibling_id == 2 || $request->sibling_id == 1) && $request->parent_id != "") {
                } elseif ($request->sibling_id == 2 && $request->parent_id == "") {

                    $username = $request->guardians_phone ? $request->guardians_phone : $request->guardians_email;
                    $phone_number = $request->guardians_phone;
                    $user_parent = $this->addUser(null, 3, $username, $request->guardians_email, $phone_number);
                    $user_parent->toArray();
                }
                // end
                //sibling & parent info update
                if ($request->sibling_id == 0 && $request->parent_id != "") {
                    SmParent::destroy($student_detail->parent_id);
                } elseif (($request->sibling_id == 2 || $request->sibling_id == 1) && $request->parent_id != "") {
                } else {

                    if (($request->sibling_id == 0 || $request->sibling_id == 1) && $request->parent_id == "") {
                        $parent = SmParent::find($student_detail->parent_id);
                    } elseif ($request->sibling_id == 2 && $request->parent_id == "") {
                        $parent = new SmParent();
                    }

                    if ($parent) {
                        $parent->user_id = $user_parent->id;
                        if ($request->filled('fathers_name')) {
                            $parent->fathers_name = $request->fathers_name;
                        }
                        if ($request->filled('fathers_phone')) {
                            $parent->fathers_mobile = $request->fathers_phone;
                        }
                        if ($request->filled('fathers_occupation')) {
                            $parent->fathers_occupation = $request->fathers_occupation;
                        }
                        if ($request->filled('fathers_photo')) {
                            $parent->fathers_photo = fileUpdate($parent->fathers_photo, $request->fathers_photo, $student_file_destination);
                        }
                        if ($request->filled('mothers_name')) {
                            $parent->mothers_name = $request->mothers_name;
                        }
                        if ($request->filled('mothers_phone')) {
                            $parent->mothers_mobile = $request->mothers_phone;
                        }
                        if ($request->filled('mothers_occupation')) {
                            $parent->mothers_occupation = $request->mothers_occupation;
                        }
                        if ($request->filled('mothers_photo')) {
                            $parent->mothers_photo = fileUpdate($parent->mothers_photo, $request->mothers_photo, $student_file_destination);
                        }
                        if ($request->filled('guardians_name')) {
                            $parent->guardians_name = $request->guardians_name;
                        }
                        if ($request->filled('guardians_phone')) {
                            $parent->guardians_mobile = $request->guardians_phone;
                        }
                        if ($request->filled('guardians_email')) {
                            $parent->guardians_email = $request->guardians_email;
                        }
                        if ($request->filled('guardians_occupation')) {
                            $parent->guardians_occupation = $request->guardians_occupation;
                        }

                        if ($request->filled('relation')) {
                            $parent->guardians_relation = $request->relation;
                        }
                        if ($request->filled('relationButton')) {
                            $parent->relation = $request->relationButton;
                        }
                        if ($request->filled('guardians_photo')) {
                            $parent->guardians_photo = fileUpdate($student->parents->guardians_photo, $request->guardians_photo, $student_file_destination);
                        }
                        if ($request->filled('guardians_address')) {
                            $parent->guardians_address = $request->guardians_address;
                        }
                        if ($request->filled('is_guardian')) {
                            $parent->is_guardian = $request->is_guardian;
                        }

                        if ($request->filled('session')) {
                            $parent->created_at = $academic_year->year . '-01-01 12:00:00';
                        }
                        $parent->save();
                        $parent->toArray();
                    }
                }
                // end sibling & parent info update
                // student info update
                $student = SmStudent::find($request->id);
                if (($request->sibling_id == 0 || $request->sibling_id == 1) && $request->parent_id == "") {
                    $student->parent_id = @$parent->id;
                } elseif ($request->sibling_id == 0 && $request->parent_id != "") {
                    $student->parent_id = $request->parent_id;
                } elseif (($request->sibling_id == 2 || $request->sibling_id == 1) && $request->parent_id != "") {
                    $student->parent_id = $request->parent_id;
                } elseif ($request->sibling_id == 2 && $request->parent_id == "") {
                    $student->parent_id = $parent->id;
                }
                if ($request->filled('class')) {
                    $student->class_id = $request->class;
                }
                if ($request->filled('section')) {
                    $student->section_id = $request->section;
                }
                if ($request->filled('session')) {
                    $student->session_id = $request->session;
                }
                if ($request->filled('admission_number')) {
                    $student->admission_no = $request->admission_number;
                }
                $student->user_id = $user_stu->id;
                if ($request->filled('roll_number')) {
                    $student->roll_no = $request->roll_number;
                }
                if ($request->filled('first_name')) {
                    $student->first_name = $request->first_name;
                }
                if ($request->filled('last_name')) {
                    $student->last_name = $request->last_name;
                }
                if ($request->filled('first_name') && $request->filled('last_name')) {
                    $student->full_name = $request->first_name . ' ' . $request->last_name;
                }
                if ($request->filled('gender')) {
                    $student->gender_id = $request->gender;
                }
                if ($request->filled('date_of_birth')) {
                    $student->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
                }
                if ($request->filled('age')) {
                    $student->age = $request->age;
                }
                if ($request->filled('caste')) {
                    $student->caste = $request->caste;
                }
                if ($request->filled('email_address')) {
                    $student->email = $request->email_address;
                }
                if ($request->filled('phone_number')) {
                    $student->mobile = $request->phone_number;
                }
                if ($request->filled('admission_date')) {
                    $student->admission_date = date('Y-m-d', strtotime($request->admission_date));
                }
                if ($request->filled('photo')) {
                    $student->student_photo = fileUpdate($parent->student_photo, $request->photo, $student_file_destination);
                }
                if ($request->filled('blood_group')) {
                    $student->bloodgroup_id = $request->blood_group;
                }
                if ($request->filled('religion')) {
                    $student->religion_id = $request->religion;
                }
                if ($request->filled('height')) {
                    $student->height = $request->height;
                }
                if ($request->filled('weight')) {
                    $student->weight = $request->weight;
                }
                if ($request->filled('current_address')) {
                    $student->current_address = $request->current_address;
                }
                if ($request->filled('permanent_address')) {
                    $student->permanent_address = $request->permanent_address;
                }
                if ($request->filled('student_category_id')) {
                    $student->student_category_id = $request->student_category_id;
                }
                if ($request->filled('student_group_id')) {
                    $student->student_group_id = $request->student_group_id;
                }
                if ($request->filled('route')) {
                    $student->route_list_id = $request->route;
                }
                if ($request->filled('dormitory_name')) {
                    $student->dormitory_id = $request->dormitory_name;
                }
                if ($request->filled('room_number')) {
                    $student->room_id = $request->room_number;
                }

                if (!empty($request->vehicle)) {
                    $driver = SmVehicle::where('id', '=', $request->vehicle)
                        ->select('driver_id')
                        ->first();
                    $student->vechile_id = $request->vehicle;
                    $student->driver_id = $driver->driver_id;
                }
                if ($request->filled('national_id_number')) {
                    $student->national_id_no = $request->national_id_number;
                }
                if ($request->filled('local_id_number')) {
                    $student->local_id_no = $request->local_id_number;
                }
                if ($request->filled('bank_account_number')) {
                    $student->bank_account_no = $request->bank_account_number;
                }
                if ($request->filled('bank_name')) {
                    $student->bank_name = $request->bank_name;
                }
                if ($request->filled('previous_school_details')) {
                    $student->previous_school_details = $request->previous_school_details;
                }
                if ($request->filled('additional_notes')) {
                    $student->aditional_notes = $request->additional_notes;
                }
                if ($request->filled('ifsc_code')) {
                    $student->ifsc_code = $request->ifsc_code;
                }
                if ($request->filled('document_title_1')) {
                    $student->document_title_1 = $request->document_title_1;
                }
                if ($request->filled('document_file_1')) {
                    $student->document_file_1 = fileUpdate($student->document_file_1, $request->file('document_file_1'), $destination);
                }
                if ($request->filled('document_title_2')) {
                    $student->document_title_2 = $request->document_title_2;
                }
                if ($request->filled('document_file_2')) {
                    $student->document_file_2 = fileUpdate($student->document_file_2, $request->file('document_file_2'), $destination);
                }
                if ($request->filled('document_title_3')) {
                    $student->document_title_3 = $request->document_title_3;
                }
                if ($request->filled('document_file_3')) {
                    $student->document_file_3 = fileUpdate($student->document_file_3, $request->file('document_file_3'), $destination);
                }
                if ($request->filled('document_title_4')) {
                    $student->document_title_4 = $request->document_title_4;
                }
                if ($request->filled('document_title_4')) {
                    $student->document_file_4 = fileUpdate($student->document_file_4, $request->file('document_file_3'), $destination);
                }

                if ($request->filled('session')) {
                    $student->created_at = $academic_year->year . '-01-01 12:00:00';
                    $student->academic_id = $academic_year->id;
                }


                if ($request->customF) {
                    $dataImage = $request->customF;
                    foreach ($dataImage as $label => $field) {
                        if (is_object($field) && $field != "") {
                            $key = "";

                            $maxFileSize = generalSetting()->file_size;
                            $file = $field;
                            $fileSize = filesize($file);
                            $fileSizeKb = ($fileSize / 1000000);
                            if ($fileSizeKb >= $maxFileSize) {
                                Toastr::error('Max upload file size ' . $maxFileSize . ' Mb is set in system', 'Failed');
                                return redirect()->back();
                            }
                            $file = $field;
                            $key = $file->getClientOriginalName();
                            $file->move('public/uploads/customFields/', $key);
                            $dataImage[$label] = 'public/uploads/customFields/' . $key;
                        }
                    }

                    //Custom Field Start
                    $student->custom_field_form_name = "student_registration";
                    $student->custom_field = json_encode($dataImage, true);
                    //Custom Field End

                }
                if (moduleStatusCheck('Lead') == true) {
                    if ($request->filled('lead_city')) {
                        $student->lead_city_id = $request->lead_city;
                    }
                    if ($request->filled('source_id')) {
                        $student->source_id = $request->source_id;
                    }
                }
                $student->save();
                DB::commit();
            }

            // session null
            $update_stud = SmStudent::where('user_id', $student->user_id)->first('student_photo');
            Session::put('profile', $update_stud->student_photo);
            Toastr::success('Operation successful', 'Success');
            return redirect('student-profile');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    private function addUser($user_id, $role_id, $username, $email, $phone_number)
    {
        try {

            $user = $user_id == null ? new User() : User::find($user_id);
            $user->role_id = $role_id;
            if ($username != null) {
                $user->username = $username;
            }
            if ($email != null) {
                $user->email = $email;
            }
            if ($phone_number != null) {
                $user->phone_number = $phone_number;
            }
            $user->save();
            return $user;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function studentProfileUpdate(Request $request, $id = null)
    {
        try {
            $student = SmStudent::find($id);

            $classes = SmClass::where('active_status', '=', '1')->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();

            $religions = SmBaseSetup::where('active_status', '=', '1')->where('base_group_id', '=', '2')->get();
            $blood_groups = SmBaseSetup::where('active_status', '=', '1')->where('base_group_id', '=', '3')->get();
            $genders = SmBaseSetup::where('active_status', '=', '1')->where('base_group_id', '=', '1')->get();
            $route_lists = SmRoute::where('active_status', '=', '1')->where('school_id', Auth::user()->school_id)->get();
            $vehicles = SmVehicle::where('active_status', '=', '1')->where('school_id', Auth::user()->school_id)->get();
            $dormitory_lists = SmDormitoryList::where('active_status', '=', '1')->where('school_id', Auth::user()->school_id)->get();
            $driver_lists = SmStaff::where([['active_status', '=', '1'], ['role_id', 9]])->where('school_id', Auth::user()->school_id)->get();
            $categories = SmStudentCategory::where('school_id', Auth::user()->school_id)->get();
            $groups = SmStudentGroup::where('school_id', Auth::user()->school_id)->get();
            $sessions = SmAcademicYear::where('active_status', '=', '1')->where('school_id', Auth::user()->school_id)->get();
            $siblings = SmStudent::where('parent_id', '!=', 0)->where('parent_id', $student->parent_id)->where('school_id', Auth::user()->school_id)->get();
            $lead_city = [];
            $sources = [];
            if (moduleStatusCheck('Lead') == true) {
                $lead_city = \Modules\Lead\Entities\LeadCity::where('school_id', auth()->user()->school_id)->get(['id', 'city_name']);
                $sources = \Modules\Lead\Entities\Source::where('school_id', auth()->user()->school_id)->get(['id', 'source_name']);
            }
            $fields = SmStudentRegistrationField::where('school_id', auth()->user()->school_id)
                ->when(auth()->user()->role_id == 2, function ($query) {
                    $query->where('student_edit', 1);
                })
                ->when(auth()->user()->role_id == 3, function ($query) {
                    $query->where('parent_edit', 1);
                })
                ->pluck('field_name')->toArray();
            $custom_fields = SmCustomField::where('form_name', 'student_registration')->where('school_id', Auth::user()->school_id)->get();
            return view('backEnd.studentPanel.my_profile_update', compact('student', 'classes', 'religions', 'blood_groups', 'genders', 'route_lists', 'vehicles', 'dormitory_lists', 'categories', 'groups', 'sessions', 'siblings', 'driver_lists', 'lead_city', 'fields', 'sources', 'custom_fields'));
        } catch (\Exception $e) {

            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function studentDashboard(Request $request, $id = null)
    {
        try {
            $user = auth()->user();
            if ($user) {
                $user_id = $user->id;
            } else {
                $user_id = $request->user_id;
            }
            $student_detail = auth()->user()->student->load('studentRecords', 'feesAssign', 'feesAssignDiscount');

            // record data
            $class_ids = $student_detail->studentRecords->pluck('class_id')->unique()->toArray();
            $section_ids = $student_detail->studentRecords->pluck('section_id')->unique()->toArray();
            // end

          
            $siblings = SmStudent::where('parent_id', $student_detail->parent_id)->where('school_id', $user->school_id)->get();
            $fees_assigneds = $student_detail->feesAssign;
            $fees_discounts = $student_detail->feesAssignDiscount;
            $documents = SmStudentDocument::where('student_staff_id', $student_detail->id)
                ->where('type', 'stu')
                ->where('academic_id', getAcademicId())
                ->where('school_id', $user->school_id)
                ->get();

            $timelines = SmStudentTimeline::where('staff_student_id', $student_detail->id)
                ->where('type', 'stu')
                ->where('visible_to_student', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', $user->school_id)
                ->get();

            $exams = SmExamSchedule::whereIn('class_id', $class_ids)
                ->whereIn('section_id', $section_ids)
                ->where('academic_id', getAcademicId())
                ->where('school_id', $user->school_id)
                ->get();

            $grades = SmMarksGrade::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', $user->school_id)
                ->get();

            $totalSubjects = SmAssignSubject::whereIn('class_id', $class_ids)
                ->whereIn('section_id', $section_ids)
                ->where('academic_id', getAcademicId())
                ->where('school_id', $user->school_id)
                ->get();

            $totalNotices = SmNoticeBoard::where('active_status', 1)
                ->where('inform_to', 'LIKE', '%2%')
                ->orderBy('id', 'DESC')
                ->where('academic_id', getAcademicId())
                ->where('school_id', $user->school_id)
                ->get();

            date_default_timezone_set(@generalSetting()->timeZone->time_zone);
            $now = date('Y-m-d');
            if (moduleStatusCheck('OnlineExam') == true) {
                $online_exams = SmaOnlineExam::where('active_status', 1)
                    ->where('status', 1)
                    ->whereIn('class_id', $class_ids)
                    ->whereIn('section_id', $section_ids)
                    ->where('academic_id', getAcademicId())
                    ->where('school_id', $user->school_id)
                    ->get();
            } else {
                $online_exams = SmOnlineExam::where('active_status', 1)
                    ->where('status', 1)
                    ->whereIn('class_id', $class_ids)
                    ->whereIn('section_id', $section_ids)
                    ->where('academic_id', getAcademicId())
                    ->where('school_id', $user->school_id)
                    ->get();
            }

            $teachers = SmAssignSubject::select('teacher_id')
                ->whereIn('class_id', $class_ids)
                ->whereIn('section_id', $section_ids)
                ->distinct('teacher_id')
                ->where('academic_id', getAcademicId())
                ->where('school_id', $user->school_id)
                ->get();

            $homeworkLists = SmHomework::whereIn('class_id', $class_ids)
                ->whereIn('section_id', $section_ids)
                ->where('evaluation_date', '=', null)
                ->where('submission_date', '>', $now)
                ->where('academic_id', getAcademicId())
                ->where('school_id', $user->school_id)
                ->get();

            $month = date('m');
            $year = date('Y');

            $attendances = SmStudentAttendance::where('student_id', $student_detail->id)
                ->where('attendance_date', 'like', $year . '-' . $month . '%')
                ->where('attendance_type', '=', 'P')
                ->where('school_id', $user->school_id)
                ->get();

            $holidays = SmHoliday::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', $user->school_id)
                ->get();

            $events = SmEvent::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', $user->school_id)
                ->where(function ($q) {
                    $q->where('for_whom', 'All')->orWhere('for_whom', 'Student');
                })
                ->get();

            $student_detail = SmStudent::where('user_id', $user->id)->first();
            $sm_weekends = SmWeekend::orderBy('order', 'ASC')
                ->where('active_status', 1)
                ->where('school_id', $user->school_id)
                ->get();

            if (moduleStatusCheck('University')) {
                $records = StudentRecord::where('student_id', $student_detail->id)
                    ->where('un_academic_id', getAcademicId())->get();
            } else {
                $records = StudentRecord::where('student_id', $student_detail->id)
                    ->where('academic_id', getAcademicId())->get();
            }
            $routineDashboard = true;

            $student_details = Auth::user()->student->load('studentRecords', 'attendances');
            $student_records = $student_details->studentRecords;

            $my_leaves = SmLeaveDefine::where('role_id', Auth::user()->role_id)->where('user_id', Auth::user()->id)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();

            $now = Carbon::now();
            $year = $now->year;
            $month  = $now->month;
            $days = cal_days_in_month(CAL_GREGORIAN, $now->month, $now->year);
            $attendance = $student_details->attendances;

            $subjectAttendance = SmSubjectAttendance::with('student')
                ->whereIn('academic_id', $student_records->pluck('academic_id'))
                ->whereIn('student_record_id', $student_records->pluck('id'))
                ->whereIn('school_id', $student_records->pluck('school_id'))
                ->get();
            $complaints = SmComplaint::with('complaintType', 'complaintSource')->get();

            $data['settings'] = SmCalendarSetting::get();
            $data['roles'] = SmaRole::where(function ($q) {
                $q->where('school_id', auth()->user()->school_id)->orWhere('type', 'System');
            })
                ->whereNotIn('id', [1, 2])
                ->get();

            $academicCalendar = new SmAcademicCalendarController();
            $data['events'] = $academicCalendar->calenderData();
            return view('backEnd.studentPanel.studentProfile', compact('totalSubjects', 'totalNotices', 'online_exams', 'teachers', 'homeworkLists', 'attendances', 'student_detail', 'fees_assigneds', 'fees_discounts', 'exams', 'documents', 'timelines', 'siblings', 'grades', 'events', 'holidays', 'sm_weekends', 'records', 'student_records', 'routineDashboard', 'my_leaves', 'attendance', 'year', 'month', 'days', 'subjectAttendance', 'complaints'), $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentsDocumentApi(Request $request, $id)
    {
        try {
            $student_detail = SmStudent::where('user_id', $id)->first();
            $documents = SmStudentDocument::where('student_staff_id', $student_detail->id)->where('type', 'stu')
                ->select('title', 'file')
                ->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['student_detail'] = $student_detail->toArray();
                $data['documents'] = $documents->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function classRoutine(Request $request, $id = null)
    {
        try {
            $user = auth()->user();
            $student_detail = SmStudent::where('user_id', $user->id)->first();
            $sm_weekends = SmWeekend::orderBy('order', 'ASC')
                ->where('active_status', 1)
                ->where('school_id', $user->school_id)
                ->get();

            if (moduleStatusCheck('University')) {
                $records = StudentRecord::where('student_id', $student_detail->id)
                    ->where('un_academic_id', getAcademicId())->get();
            } else {
                $records = StudentRecord::where('student_id', $student_detail->id)
                    ->where('academic_id', getAcademicId())->get();
            }
            return view('backEnd.studentPanel.class_routine', compact('sm_weekends', 'records'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentResult()
    {
        try {

            $student_detail = Auth::user()->student;
            $optional_subject_setup = SmClassOptionalSubject::where('class_id', '=', $student_detail->class_id)->first();
            $records = StudentRecord::where('student_id', $student_detail->id)->where('academic_id', getAcademicId())->get();
            $student_optional_subject = SmOptionalSubjectAssign::where('student_id', $student_detail->id)
                ->where('session_id', '=', $student_detail->session_id)
                ->first();

            $exams = SmExamSchedule::where('class_id', $student_detail->class_id)
                ->where('section_id', $student_detail->section_id)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $grades = SmMarksGrade::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $failgpa = SmMarksGrade::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->min('gpa');

            $failgpaname = SmMarksGrade::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->where('gpa', $failgpa)
                ->first();
            $maxgpa = SmMarksGrade::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->max('gpa');

            $exam_terms = SmExamType::where('school_id', Auth::user()->school_id)
                ->where('academic_id', getAcademicId())
                ->get();

            if (moduleStatusCheck('University')) {
                $student_id = $student_detail->id;
                $studentDetails = SmStudent::find($student_id);
                $studentRecordDetails = StudentRecord::where('student_id', $student_id);
                $studentRecords = StudentRecord::where('student_id', $student_id)->distinct('un_academic_id')->get();
                return view('backEnd.studentPanel.student_result', compact('student_detail', 'exams', 'grades', 'exam_terms', 'failgpaname', 'optional_subject_setup', 'student_optional_subject', 'maxgpa', 'records', 'studentDetails', 'studentRecordDetails', 'studentRecords'));
            } else {
                return view('backEnd.studentPanel.student_result', compact('student_detail', 'exams', 'grades', 'exam_terms', 'failgpaname', 'optional_subject_setup', 'student_optional_subject', 'maxgpa', 'records'));
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentResultDownload(Request $request)
    {
        try {
            // $eligible_subjects = SmAssignSubject::where('class_id', $request->class_id)
            //     ->where('section_id', $request->section_id)
            //     ->where('academic_id', getAcademicId())
            //     ->where('school_id', Auth::user()->school_id)
            //     ->select('subject_id')
            //     ->distinct(['section_id', 'subject_id'])
            //     ->get()
            //     ->pluck('subject_id');

            $eligible_subjects = SmResultStore::where([
                ['exam_type_id', $request->exam_id],
                ['student_id', $request->student_id],
                ['student_record_id', $request->record_id],
            ])
                ->get()
                ->pluck('subject_id');

            $student_detail = Auth::user()->student;
            $optional_subject_setup = SmClassOptionalSubject::where('class_id', '=', $student_detail->class_id)->first();
            $record = StudentRecord::where('student_id', $student_detail->id)->where('academic_id', getAcademicId())->find($request->record_id);
            $student_optional_subject = SmOptionalSubjectAssign::where('student_id', $student_detail->id)
                ->where('session_id', '=', $student_detail->session_id)
                ->first();

            $grades = SmMarksGrade::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $failgpa = SmMarksGrade::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->min('gpa');

            $failgpaname = SmMarksGrade::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->where('gpa', $failgpa)
                ->first();

            $maxgpa = SmMarksGrade::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->max('gpa');

            // $marks = SmResultStore::with(['subject'])->where([
            //     ['exam_type_id', $request->exam_id],
            //     ['student_id', $request->student_id],
            //     ['student_record_id', $request->record_id],
            // ])->get();

            $school = SmSchool::find(Auth::user()->school_id);

            $class = SmClass::find($request->class_id);

            $section = SmSection::find($request->section_id);

            $exam = SmExamType::with('examSettings')->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->where('id', $request->exam_id)
                ->first();

            $marksheet = [
                "grand_total" => 0,
                "grand_total_marks" => 0,
                "temp_grade" => [],
                "total_gpa_point" => 0,
                "total_subject" => 0,
                "optional_subject" => 0,
                "optional_gpa" => 0,
                "pass" => 0,
                'theory' => 0,
                "result_type" => @generalSetting()->result_type,
                "publish_date" => $exam->examSettings->publish_date,
                "publish_moth_year" => $exam->examSettings->publish_date ? Carbon::parse($exam->examSettings->publish_date)->format('F Y') : null,
            ];

            $i = 0;
            $results = [];

            $subjects = SmSubject::whereIn('id', $eligible_subjects)->get();

            $marksheet["total_subject"] =  count($subjects);

            foreach ($subjects as $subject) {
                $results[$i] = [
                    "id" => $subject->id,
                    "subject_name" => $subject->subject_name,
                    "subject_code" => $subject->subject_code,
                    "subject_type" => $subject->subject_type,
                    "pass_mark" => $subject->pass_mark,
                    "total_marks" => null,
                    "exam_mark" => null,
                    "is_absent" => null,
                    "total_gpa_point" => null,
                    "total_gpa_grade" => null,
                    "teacher_remarks" => null,
                    "percentage" => null,
                    "result" => null,
                    "pass" => 0,
                    "total_gpa_point_format" => null
                ];

                if ($subject->subject_type == 'T') $marksheet["theory"]++;

                $mark = SmResultStore::where([
                    ['exam_type_id', $request->exam_id],
                    ['student_id', $request->student_id],
                    ['student_record_id', $request->record_id],
                    ['class_id', $request->class_id],
                    ['section_id', $request->section_id],
                    ['subject_id', $subject->id]
                ])->first();

                if (!isset($mark)) {
                    $results[$i]["mark"] = null;
                    $i++;
                    continue;
                }

                if (!is_null($optional_subject_setup) && !is_null($student_optional_subject)) {
                    if ($subject->id != @$student_optional_subject->subject_id) {
                        $temp_grade[] = $mark->total_gpa_grade;
                    }
                } else {
                    $temp_grade[] = $mark->total_gpa_grade;
                }

                $marksheet["total_gpa_point"] += $mark->total_gpa_point;
                if (!is_null(@$student_optional_subject)) {
                    if (@$student_optional_subject->subject_id == $mark->subject->id && $mark->total_gpa_point < @$optional_subject_setup->gpa_above) {
                        $marksheet["total_gpa_point"] = $marksheet["total_gpa_point"] - $mark->total_gpa_point;
                    }
                }
                $temp_gpa[] = $mark->total_gpa_point;
                $exam_mark = subjectExamMark($mark->exam_type_id, $subject->id, $mark->studentRecord->class_id, $mark->studentRecord->section_id);
                $results[$i]['exam_mark'] = $exam_mark ? $exam_mark->exam_mark : null;
                $results[$i]['pass_mark'] = $exam_mark ? $exam_mark->pass_mark : null;
                $results[$i]['total_marks'] = $mark->total_marks;

                $subject_marks = SmStudent::fullMarksBySubject($exam->id, $mark->subject_id);
                $schedule_by_subject = SmStudent::scheduleBySubject($exam->id, $mark->subject_id, @$record);

                if (@$mark->is_absent == 0) {
                    $results[$i]['is_absent'] = $mark->is_absent;
                    if ($marksheet["result_type"] == 'mark') {
                        $marksheet["grand_total"] += @subjectPercentageMark(@$mark->total_marks, @$exam_mark->exam_mark);
                    } else {
                        $marksheet["grand_total"] += @$mark->total_marks;
                    }
                    if ($mark->marks >= @$exam_mark->pass_mark) {
                        $results[$i]['pass'] = 1;
                        $marksheet["pass"]++;
                    }
                }

                if ($marksheet["result_type"] == 'mark') {
                    $marksheet["grand_total_marks"] += @$exam_mark->exam_mark;
                    $results[$i]['percentage'] = @subjectPercentageMark(@$mark->total_marks, @$exam_mark->exam_mark);
                    $totalMark = subjectPercentageMark(@$mark->total_marks, @$exam_mark->exam_mark);
                    $passMark = $exam_mark->pass_mark;
                    if ($passMark < $totalMark)
                        $results[$i]['result'] = __('exam.pass');
                    else
                        $results[$i]['result'] = __('exam.fail');
                } else {
                    $marksheet["grand_total_marks"] += @$exam_mark->exam_mark;
                    $results[$i]['percentage'] = @subjectPercentageMark(@$mark->total_marks, @$exam_mark->exam_mark);
                    $results[$i]['total_gpa_point_format'] = number_format(@$mark->total_gpa_point, 2, '.', '');
                }

                $results[$i]['schedule_by_subject'] = !empty($schedule_by_subject->date) ? dateConvert($schedule_by_subject->date) : '';

                $results[$i]["total_gpa_point"] = $mark->total_gpa_point;
                $results[$i]["total_gpa_grade"] = $mark->total_gpa_grade;
                $results[$i]["teacher_remarks"] = $mark->teacher_remarks;

                // $results[$i]["mark"] = $mark;

                $i++;
            }

            $marksheet['position'] = getStudentMeritPosition($record->class_id, $record->section_id, $exam->id, $record->id);
            // $marksheet['grand_total'] = $marksheet['grand_total'] / $marksheet['grand_total_marks'];

            if (in_array($failgpaname->grade_name, $temp_grade)) {
                $marksheet['grade_name'] = $failgpaname->grade_name;
            } else {
                $final_gpa_point = ($marksheet["total_gpa_point"] - $marksheet["optional_gpa"]) / ($marksheet["total_subject"] - $marksheet["optional_subject"]);
                $average_grade = 0;
                $average_grade_max = 0;
                if ($i == 0 && $marksheet["grand_total_marks"] != 0) {
                    $gpa_point = number_format($final_gpa_point, 2, '.', '');
                    if ($gpa_point >= $maxgpa) {
                        $average_grade_max = SmMarksGrade::where('school_id', Auth::user()->school_id)
                            ->where('academic_id', getAcademicId())
                            ->where('from', '<=', $maxgpa)
                            ->where('up', '>=', $maxgpa)
                            ->first('grade_name');

                        $marksheet['grade_name'] = @$average_grade_max->grade_name;
                    } else {
                        $average_grade = SmMarksGrade::where('school_id', Auth::user()->school_id)
                            ->where('academic_id', getAcademicId())
                            ->where('from', '<=', $final_gpa_point)
                            ->where('up', '>=', $final_gpa_point)
                            ->first('grade_name');
                        $marksheet['grade_name'] = @$average_grade->grade_name;
                    }
                } else {
                    $marksheet['grade_name'] = $failgpaname->grade_name;
                }
            }

            $final_gpa_point = 0;
            $final_gpa_point = ($marksheet["total_gpa_point"] - $marksheet["optional_gpa"]) / ($marksheet["total_subject"] - $marksheet["optional_subject"]);
            $float_final_gpa_point = number_format($final_gpa_point, 2);
            if ($float_final_gpa_point >= $maxgpa) {
                $marksheet['gpa'] = $maxgpa;
            } else {
                $marksheet['gpa'] = $float_final_gpa_point;
            }
            // return response()->json(['marksheet' => $marksheet, 'marks' => $results, 'exam' => $exam, 'school' => $school, 'student' => $student_detail, 'section' => $section, 'class' => $class]);

            // return view('pdf.marksheet', ['marksheet' => $marksheet, 'marks' => $marks, 'exam' => $exam, 'school' => $school, 'student' => $student_detail, 'section' => $section, 'class' => $class]);

            $pdf = Pdf::loadView('pdf.marksheet', ['marksheet' => $marksheet, 'marks' => $results, 'exam' => $exam, 'school' => $school, 'student' => $student_detail, 'section' => $section, 'class' => $class]);
            return $pdf->download(date('d-m-Y') . '-mark-sheet.pdf');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentExamSchedule()
    {
        try {
            $student_detail = Auth::user()->student;
            $records = studentRecords(null, $student_detail->id)->get();
            return view('backEnd.studentPanel.exam_schedule', compact('records'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentExamScheduleSearch(Request $request)
    {
        $request->validate([
            'exam' => 'required',
        ]);

        try {
            $student_detail = Auth::user()->student;
            $records = studentRecords(null, $student_detail->id)->get();
            $smExam = SmExam::findOrFail($request->exam);
            $assign_subjects = SmAssignSubject::where('class_id', $smExam->class_id)->where('section_id', $smExam->section_id)
                ->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();

            if ($assign_subjects->count() == 0) {
                Toastr::error('No Subject Assigned.', 'Failed');
                return redirect('student-exam-schedule');
            }

            $exams = SmExam::where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            $class_id = $smExam->class_id;
            $section_id = $smExam->section_id;
            $exam_id = $smExam->id;
            $exam_type_id = $smExam->exam_type_id;
            $exam_periods = SmClassTime::where('type', 'exam')->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            $exam_schedule_subjects = "";
            $assign_subject_check = "";

            $exam_routines = SmExamSchedule::where('class_id', $class_id)
                ->where('section_id', $section_id)
                ->where('exam_term_id', $exam_type_id)
                ->orderBy('date', 'ASC')->get();

            return view('backEnd.studentPanel.exam_schedule', compact('exams', 'assign_subjects', 'class_id', 'section_id', 'exam_id', 'exam_schedule_subjects', 'assign_subject_check', 'exam_type_id', 'exam_periods', 'exam_routines', 'records'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function examRoutinePrint($class_id, $section_id, $exam_term_id)
    {

        try {

            $exam_type_id = $exam_term_id;
            $exam_type = SmExamType::find($exam_type_id)->title;
            $academic_id = SmExamType::find($exam_type_id)->academic_id;
            $academic_year = SmAcademicYear::find($academic_id);
            $class_name = SmClass::find($class_id)->class_name;
            $section_name = SmSection::find($section_id)->section_name;

            $exam_schedules = SmExamSchedule::where('class_id', $class_id)->where('section_id', $section_id)
                ->where('exam_term_id', $exam_type_id)->orderBy('date', 'ASC')->get();

            $pdf = Pdf::loadView(
                'backEnd.examination.exam_schedule_print',
                [
                    'exam_schedules' => $exam_schedules,
                    'exam_type' => $exam_type,
                    'class_name' => $class_name,
                    'academic_year' => $academic_year,
                    'section_name' => $section_name,

                ]
            )->setPaper('A4', 'landscape');
            return $pdf->stream('EXAM_SCHEDULE.pdf');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentExamScheduleApi(Request $request, $id)
    {
        try {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $student_detail = SmStudent::where('user_id', $id)->first();
                // $assign_subjects = SmAssignSubject::where('class_id', $student_detail->class_id)->where('section_id', $student_detail->section_id)->where('academic_id', getAcademicId())->where('school_id',Auth::user()->school_id)->get();
                $exam_schedule = DB::table('sm_exam_schedules')
                    ->join('sm_students', 'sm_students.class_id', '=', 'sm_exam_schedules.class_id')
                    ->join('sm_exam_types', 'sm_exam_types.id', '=', 'sm_exam_schedules.exam_term_id')
                    ->join('sm_exam_schedule_subjects', 'sm_exam_schedule_subjects.exam_schedule_id', '=', 'sm_exam_schedules.id')
                    ->join('sm_subjects', 'sm_subjects.id', '=', 'sm_exam_schedules.subject_id')
                    ->select('sm_subjects.subject_name', 'sm_exam_schedule_subjects.start_time', 'sm_exam_schedule_subjects.end_time', 'sm_exam_schedule_subjects.date', 'sm_exam_schedule_subjects.room', 'sm_exam_schedules.class_id', 'sm_exam_schedules.section_id')
                    //->where('sm_students.class_id', '=', 'sm_exam_schedules.class_id')

                    ->where('sm_exam_schedules.section_id', '=', $student_detail->section_id)
                    ->where('sm_exam_schedulesacademic_id', getAcademicId())->where('sm_exam_schedules.school_id', Auth::user()->school_id)->get();
                return ApiBaseMethod::sendResponse($exam_schedule, null);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentViewExamSchedule($id)
    {
        try {
            $user = Auth::user();
            $student_detail = SmStudent::where('user_id', $user->id)->first();
            $class = SmClass::find($student_detail->class_id);
            $section = SmSection::find($student_detail->section_id);
            $assign_subjects = SmExamScheduleSubject::where('exam_schedule_id', $id)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();

            return view('backEnd.examination.view_exam_schedule_modal', compact('class', 'section', 'assign_subjects'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    
    public function studentHomework(Request $request, $id = null)
    {
        try {

            $user = Auth::user();
            $student_detail = SmStudent::where('user_id', $user->id)->first();
            $records = $student_detail->studentRecords;

            return view('backEnd.studentPanel.student_homework', compact('student_detail', 'records'));
        } catch (\Exception $e) {

            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentHomeworkView($class_id, $section_id, $homework_id)
    {
        try {
            $homeworkDetails = SmHomework::where('class_id', '=', $class_id)->where('section_id', '=', $section_id)->where('id', '=', $homework_id)->first();
            return view('backEnd.studentPanel.studentHomeworkView', compact('homeworkDetails', 'homework_id'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function unStudentHomeworkView($sem_label_id, $homework)
    {
        try {
            $homeworkDetails = SmHomework::find($homework);
            $homework_id = $homework;
            return view('backEnd.studentPanel.studentHomeworkView', compact('homeworkDetails', 'homework_id'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function addHomeworkContent($homework_id)
    {
        try {
            return view('backEnd.studentPanel.addHomeworkContent', compact('homework_id'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function deleteViewHomeworkContent($homework_id)
    {
        try {

            return view('backEnd.studentPanel.deleteHomeworkContent', compact('homework_id'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function deleteHomeworkContent($homework_id)
    {
        try {
            $user = Auth::user();
            $student_detail = SmStudent::where('user_id', $user->id)->first();
            $contents = SmUploadHomeworkContent::where('student_id', $student_detail->id)->where('homework_id', $homework_id)->get();
            foreach ($contents as $key => $content) {
                if ($content->file != "") {
                    if (file_exists($content->file)) {
                        unlink($content->file);
                    }
                }
                $content->delete();
            }

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function uploadHomeworkContent(Request $request)
    {
        // $input = $request->all();
        // $validator = Validator::make($input, [
        //     'files' => "mimes:pdf,doc,docx,jpg,jpeg,png,mp4,mp3,txt",
        // ]);

        // if ($validator->fails()) {
        //     Toastr::warning('Unsupported file upload', 'Failed');
        //     return redirect()->back();
        // }

        if ($request->file('files') == "") {
            Toastr::error('No file uploaded', 'Failed');
            return redirect()->back();
        }
        try {
            $user = Auth::user();
            $student_detail = SmStudent::where('user_id', $user->id)->first();
            $data = [];
            foreach ($request->file('files') as $key => $file) {
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/homeworkcontent/', $fileName);
                $fileName = 'public/uploads/homeworkcontent/' . $fileName;
                $data[$key] = $fileName;
            }
            $all_filename = json_encode($data);
            $content = new SmUploadHomeworkContent();
            $content->file = $all_filename;
            $content->student_id = $student_detail->id;
            $content->homework_id = $request->id;
            $content->school_id = Auth::user()->school_id;
            $content->academic_id = getAcademicId();
            $content->save();

            $homework_info = SmHomeWork::find($request->id);
            $teacher_info = $teacher_info = User::find($homework_info->created_by);

            $notification = new SmNotification;
            $notification->user_id = $teacher_info->id;
            $notification->role_id = $teacher_info->role_id;
            $notification->date = date('Y-m-d');
            $notification->message = Auth::user()->student->full_name . ' ' . app('translator')->get('homework.submitted_homework');
            $notification->school_id = Auth::user()->school_id;
            $notification->academic_id = getAcademicId();
            $notification->save();

            try {
                $user = User::find($teacher_info->id);
                Notification::send($user, new StudentHomeworkSubmitNotification($notification));
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }

            Toastr::success('Operation successful', 'Success');
            if ($request->status == 'lmsHomework') {
                return redirect()->to(url('lms/watchCourse', $request->course_id));
            } else {
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function uploadContentView(Request $request, $id)
    {
        try {
            $ContentDetails = SmTeacherUploadContent::where('id', $id)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->first();
            return view('backEnd.studentPanel.uploadContentDetails', compact('ContentDetails'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentAssignment()
    {
        try {
            $user = Auth::user();
            $student_detail = SmStudent::where('user_id', $user->id)->first();
            if (moduleStatusCheck('University')) {
                $records = StudentRecord::where('student_id', $student_detail->id)->where('un_academic_id', getAcademicId())->get();
            } else {
                $records = StudentRecord::where('student_id', $student_detail->id)->where('academic_id', getAcademicId())->get();
            }

            $uploadContents = SmTeacherUploadContent::where('course_id', '=', null)
                ->where('chapter_id', '=', null)
                ->where('lesson_id', '=', null)
                ->where('content_type', 'as')
                ->where(function ($query) use ($student_detail) {
                    $query->where('available_for_all_classes', 1)
                        ->orWhere([['class', $student_detail->class_id], ['section', $student_detail->section_id]]);
                })
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();
            if (Auth()->user()->role_id != 1) {
                if ($user->role_id == 2) {
                    SmNotification::where('user_id', $user->student->id)->where('role_id', 2)->update(['is_read' => 1]);
                }
            }

            $uploadContents2 = SmTeacherUploadContent::where('course_id', '=', null)
                ->where('chapter_id', '=', null)
                ->where('lesson_id', '=', null)
                ->where('content_type', 'as')
                ->where('class', $student_detail->class_id)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();

            return view('backEnd.studentPanel.assignmentList', compact('uploadContents', 'uploadContents2', 'records'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentAssignmentApi(Request $request, $id)
    {
        try {
            $student_detail = SmStudent::where('user_id', $id)->first();
            $uploadContents = SmTeacherUploadContent::where('content_type', 'as')
                ->select('content_title', 'upload_date', 'description', 'upload_file')
                ->where(function ($query) use ($student_detail) {
                    $query->where('available_for_all_classes', 1)
                        ->orWhere([['class', $student_detail->class_id], ['section', $student_detail->section_id]]);
                })->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['student_detail'] = $student_detail->toArray();
                $data['uploadContents'] = $uploadContents->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentStudyMaterial()
    {

        try {
            $user = Auth::user();
            $student_detail = SmStudent::where('user_id', $user->id)->first();

            $uploadContents = SmTeacherUploadContent::where('content_type', 'st')
                ->where(function ($query) use ($student_detail) {
                    $query->where('available_for_all_classes', 1)
                        ->orWhere([['class', $student_detail->class_id], ['section', $student_detail->section_id]]);
                })->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();

            return view('backEnd.studentPanel.studyMetarialList', compact('uploadContents'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentSyllabus()
    {
        try {
            $user = Auth::user();
            $student_detail = SmStudent::where('user_id', $user->id)->first();
            if (moduleStatusCheck('University')) {
                $records = StudentRecord::where('student_id', $student_detail->id)->where('un_academic_id', getAcademicId())->get();
            } else {
                $records = StudentRecord::where('student_id', $student_detail->id)->where('academic_id', getAcademicId())->get();
            }

            $uploadContents = SmTeacherUploadContent::where('content_type', 'sy')
                ->where(function ($query) use ($student_detail) {
                    $query->where('available_for_all_classes', 1)
                        ->orWhere([['class', $student_detail->class_id], ['section', $student_detail->section_id]]);
                })->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();

            $uploadContents2 = SmTeacherUploadContent::where('content_type', 'ot')
                ->where('class', $student_detail->class_id)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();

            return view('backEnd.studentPanel.studentSyllabus', compact('uploadContents', 'uploadContents2', 'records'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function othersDownload()
    {
        try {
            $user = Auth::user();
            $student_detail = SmStudent::where('user_id', $user->id)->first();
            $uploadContents = SmTeacherUploadContent::where('content_type', 'ot')
                ->where(function ($query) use ($student_detail) {
                    $query->where('available_for_all_classes', 1)
                        ->orWhere([['class', $student_detail->class_id], ['section', $student_detail->section_id]]);
                })->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();

            $uploadContents2 = SmTeacherUploadContent::where('content_type', 'ot')
                ->where('class', $student_detail->class_id)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();

            if (moduleStatusCheck('University')) {
                $records = StudentRecord::where('student_id', $student_detail->id)->where('un_academic_id', getAcademicId())->get();
            } else {
                $records = StudentRecord::where('student_id', $student_detail->id)->where('academic_id', getAcademicId())->get();
            }

            return view('backEnd.studentPanel.othersDownload', compact('uploadContents', 'uploadContents2', 'records'));
        } catch (\Exception $e) {

            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentSubject()
    {
        try {
            $user = Auth::user();
            if (moduleStatusCheck('University')) {
                $records = StudentRecord::where('student_id', $user->student->id)->where('un_academic_id', getAcademicId())->get();
            } else {
                $records = StudentRecord::where('student_id', $user->student->id)->where('academic_id', getAcademicId())->get();
            }
            return view('backEnd.studentPanel.student_subject', compact('records'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    //Student Subject API
    public function studentSubjectApi(Request $request, $id)
    {
        try {
            $student = SmStudent::where('user_id', $id)->first();
            $assignSubjects = DB::table('sm_assign_subjects')
                ->leftjoin('sm_subjects', 'sm_subjects.id', '=', 'sm_assign_subjects.subject_id')
                ->leftjoin('sm_staffs', 'sm_staffs.id', '=', 'sm_assign_subjects.teacher_id')
                ->select('sm_subjects.subject_name', 'sm_subjects.subject_code', 'sm_subjects.subject_type', 'sm_staffs.full_name as teacher_name')
                ->where('sm_assign_subjects.class_id', '=', $student->class_id)
                ->where('sm_assign_subjects.section_id', '=', $student->section_id)
                ->where('sm_assign_subjects.academic_id', getAcademicId())->where('sm_assign_subjects.school_id', Auth::user()->school_id)->get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['student_subjects'] = $assignSubjects->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    //student panel Transport
    public function studentTransport()
    {
        try {
            $studentBehaviourRecords = (moduleStatusCheck('BehaviourRecords')) ? AssignIncident::where('student_id', auth()->user()->student->id)->with('incident', 'user', 'academicYear')->get() : null;
            $behaviourRecordSetting = BehaviourRecordSetting::where('id', 1)->first();
            $user = Auth::user();
            $student_detail = SmStudent::where('user_id', $user->id)->first();

            // $routes = SmAssignVehicle::where('active_status', 1)->where('school_id',Auth::user()->school_id)->get();
            $routes = SmAssignVehicle::join('sm_vehicles', 'sm_assign_vehicles.vehicle_id', 'sm_vehicles.id')
                ->join('sm_students', 'sm_vehicles.id', 'sm_students.vechile_id')
                ->where('sm_assign_vehicles.active_status', 1)
                ->where('sm_students.user_id', Auth::user()->id)
                ->where('sm_assign_vehicles.school_id', Auth::user()->school_id)
                ->get();

            return view('backEnd.studentPanel.student_transport', compact('routes', 'student_detail', 'studentBehaviourRecords', 'behaviourRecordSetting'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentTransportViewModal($r_id, $v_id)
    {
        try {
            $vehicle = SmVehicle::find($v_id);
            $route = SmRoute::find($r_id);
            return view('backEnd.studentPanel.student_transport_view_modal', compact('route', 'vehicle'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentDormitory()
    {
        try {
            $user = Auth::user();
            $student_detail = SmStudent::where('user_id', $user->id)->first();
            // $room_lists = SmRoomList::where('school_id',Auth::user()->school_id)->get();
            // $room_lists = SmRoomList::join('sm_students','sm_students.room_id','sm_room_lists.id')
            // ->where('sm_room_lists.active_status', 1)->where('sm_room_lists.id', $student_detail->room_id)->where('sm_room_lists.school_id',Auth::user()->school_id)->get();
            $room_lists = SmRoomList::where('active_status', 1)->where('id', $student_detail->room_id)->where('school_id', Auth::user()->school_id)->get();

            $room_lists = $room_lists->groupBy('dormitory_id');
            $room_types = SmRoomType::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            $dormitory_lists = SmDormitoryList::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            return view('backEnd.studentPanel.student_dormitory', compact('room_lists', 'room_types', 'dormitory_lists', 'student_detail'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentBookList()
    {
        try {
            $books = SmBook::where('active_status', 1)
                ->orderBy('id', 'DESC')
                ->where('school_id', Auth::user()->school_id)->get();
            return view('backEnd.studentPanel.studentBookList', compact('books'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentBookIssue()
    {
        try {
            $user = Auth::user();
            $student_detail = SmStudent::where('user_id', $user->id)->first();
            // $books = SmBook::select('id', 'book_title')->where('active_status', 1)->where('school_id',Auth::user()->school_id)->get();
            // $subjects = SmSubject::select('id', 'subject_name')->where('active_status', 1)->where('school_id',Auth::user()->school_id)->get();
            $library_member = SmLibraryMember::where('member_type', 2)->where('student_staff_id', $student_detail->user_id)->first();
            if (empty($library_member)) {
                Toastr::error('You are not library member ! Please contact with librarian', 'Failed');
                return redirect()->back();
                // return redirect()->back()->with('message-danger', 'You are not library member ! Please contact with librarian');
            }
            $issueBooks = SmBookIssue::where('member_id', $library_member->student_staff_id)
                ->leftjoin('sm_books', 'sm_books.id', 'sm_book_issues.book_id')
                ->leftjoin('library_subjects', 'library_subjects.id', 'sm_books.book_subject_id')
                // ->where('sm_book_issues.issue_status', 'I')
                ->where('sm_book_issues.school_id', Auth::user()->school_id)
                ->get();

            return view('backEnd.studentPanel.studentBookIssue', compact('issueBooks'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentNoticeboard(Request $request)
    {
        try {
            $data = [];
            $allNotices = SmNoticeBoard::where('active_status', 1)->where('inform_to', 'LIKE', '%2%')
                ->orderBy('id', 'DESC')
                ->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data['allNotices'] = $allNotices->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.studentPanel.studentNoticeboard', compact('allNotices'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentTeacher()
    {
        try {
            $student_detail = Auth::user()->student->load('studentRecords');
            $records = $student_detail->studentRecords;
            $teacherEvaluationSetting = TeacherEvaluationSetting::find(1);
            return view('backEnd.studentPanel.studentTeacher', compact('records', 'teacherEvaluationSetting'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function studentTeacherApi(Request $request, $id)
    {
        try {
            $student = SmStudent::where('user_id', $id)->first();

            $assignTeacher = DB::table('sm_assign_subjects')
                ->leftjoin('sm_subjects', 'sm_subjects.id', '=', 'sm_assign_subjects.subject_id')
                ->leftjoin('sm_staffs', 'sm_staffs.id', '=', 'sm_assign_subjects.teacher_id')
                //->select('sm_subjects.subject_name', 'sm_subjects.subject_code', 'sm_subjects.subject_type', 'sm_staffs.full_name')
                ->select('sm_staffs.full_name', 'sm_staffs.email', 'sm_staffs.mobile')
                ->where('sm_assign_subjects.class_id', '=', $student->class_id)
                ->where('sm_assign_subjects.section_id', '=', $student->section_id)
                ->where('sm_assign_subjects.school_id', Auth::user()->school_id)->get();

            $class_teacher = DB::table('sm_class_teachers')
                ->join('sm_assign_class_teachers', 'sm_assign_class_teachers.id', '=', 'sm_class_teachers.assign_class_teacher_id')
                ->join('sm_staffs', 'sm_class_teachers.teacher_id', '=', 'sm_staffs.id')
                ->where('sm_assign_class_teachers.class_id', '=', $student->class_id)
                ->where('sm_assign_class_teachers.section_id', '=', $student->section_id)
                ->where('sm_assign_class_teachers.active_status', '=', 1)
                ->select('full_name')
                ->first();
            $settings = SmGeneralSettings::find(1);
            if (@$settings->phone_number_privacy == 1) {
                $permission = 1;
            } else {
                $permission = 0;
            }

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['teacher_list'] = $assignTeacher->toArray();
                $data['class_teacher'] = $class_teacher;
                $data['permission'] = $permission;
                return ApiBaseMethod::sendResponse($data, null);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentLibrary(Request $request, $id)
    {
        try {
            $student = SmStudent::where('user_id', $id)->first();
            $issueBooks = DB::table('sm_book_issues')
                ->leftjoin('sm_books', 'sm_books.id', '=', 'sm_book_issues.book_id')
                ->where('sm_book_issues.member_id', '=', $student->user_id)
                ->where('sm_book_issues.school_id', Auth::user()->school_id)->get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['issueBooks'] = $issueBooks->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function studentDormitoryApi(Request $request)
    {
        try {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $studentDormitory = DB::table('sm_room_lists')
                    ->join('sm_dormitory_lists', 'sm_room_lists.dormitory_id', '=', 'sm_dormitory_lists.id')
                    ->join('sm_room_types', 'sm_room_lists.room_type_id', '=', 'sm_room_types.id')
                    ->select('sm_dormitory_lists.dormitory_name', 'sm_room_lists.name as room_number', 'sm_room_lists.number_of_bed', 'sm_room_lists.cost_per_bed', 'sm_room_lists.active_status')->where('sm_room_lists.school_id', Auth::user()->school_id)->get();

                return ApiBaseMethod::sendResponse($studentDormitory, null);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function studentTimelineApi(Request $request, $id)
    {
        try {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                //$timelines = SmStudentTimeline::where('staff_student_id', $id)->first();
                $timelines = DB::table('sm_student_timelines')
                    ->leftjoin('sm_students', 'sm_students.id', '=', 'sm_student_timelines.staff_student_id')
                    ->where('sm_student_timelines.type', '=', 'stu')
                    ->where('sm_student_timelines.active_status', '=', 1)
                    ->where('sm_students.user_id', '=', $id)
                    ->select('title', 'date', 'description', 'file', 'sm_student_timelines.active_status')
                    ->where('sm_student_timelines.academic_id', getAcademicId())->where('sm_students.school_id', Auth::user()->school_id)->get();
                return ApiBaseMethod::sendResponse($timelines, null);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function examListApi(Request $request, $id)
    {
        try {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {

                $student = SmStudent::where('user_id', $id)->first();
                // return  $student;
                $exam_List = DB::table('sm_exam_types')
                    ->join('sm_exams', 'sm_exams.exam_type_id', '=', 'sm_exam_types.id')
                    ->where('sm_exams.class_id', '=', $student->class_id)
                    ->where('sm_exams.section_id', '=', $student->section_id)
                    ->distinct()
                    ->select('sm_exam_types.id as exam_id', 'sm_exam_types.title as exam_name')
                    ->where('sm_exam_types.school_id', Auth::user()->school_id)->get();
                return ApiBaseMethod::sendResponse($exam_List, null);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function examScheduleApi(Request $request, $id, $exam_id)
    {
        try {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $student = SmStudent::where('user_id', $id)->first();
                $exam_schedule = DB::table('sm_exam_schedules')
                    ->join('sm_exam_types', 'sm_exam_types.id', '=', 'sm_exam_schedules.exam_term_id')
                    // ->join('sm_exam_types','sm_exam_types.id','=','sm_exam_schedules.exam_term_id' )
                    ->join('sm_subjects', 'sm_subjects.id', '=', 'sm_exam_schedules.subject_id')
                    ->join('sm_class_rooms', 'sm_class_rooms.id', '=', 'sm_exam_schedules.room_id')
                    ->join('sm_class_times', 'sm_class_times.id', '=', 'sm_exam_schedules.exam_period_id')
                    ->where('sm_exam_schedules.exam_term_id', '=', $exam_id)
                    ->where('sm_exam_schedules.school_id', '=', $student->school_id)
                    ->where('sm_exam_schedules.class_id', '=', $student->class_id)
                    ->where('sm_exam_schedules.section_id', '=', $student->section_id)
                    ->where('sm_exam_schedules.active_status', '=', 1)
                    ->select('sm_exam_types.id', 'sm_exam_types.title as exam_name', 'sm_subjects.subject_name', 'date', 'sm_class_rooms.room_no', 'sm_class_times.start_time', 'sm_class_times.end_time')
                    ->where('sm_exam_schedules.school_id', Auth::user()->school_id)->get();
                return ApiBaseMethod::sendResponse($exam_schedule, null);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function examResultApi(Request $request, $id, $exam_id)
    {
        try {
            $data = [];

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $student = SmStudent::where('user_id', $id)->first();
                $exam_result = DB::table('sm_result_stores')
                    ->join('sm_exam_types', 'sm_exam_types.id', '=', 'sm_result_stores.exam_type_id')
                    ->join('sm_exams', 'sm_exams.id', '=', 'sm_exam_types.id')
                    ->join('sm_subjects', 'sm_subjects.id', '=', 'sm_result_stores.subject_id')
                    ->where('sm_exams.id', '=', $exam_id)
                    ->where('sm_result_stores.school_id', '=', $student->school_id)
                    ->where('sm_result_stores.class_id', '=', $student->class_id)
                    ->where('sm_result_stores.section_id', '=', $student->section_id)
                    ->where('sm_result_stores.student_id', '=', $student->id)
                    ->select('sm_exams.id', 'sm_exam_types.title as exam_name', 'sm_subjects.subject_name', 'sm_result_stores.total_marks as obtained_marks', 'sm_exams.exam_mark as total_marks', 'sm_result_stores.total_gpa_grade as grade')
                    ->where('sm_exams.school_id', Auth::user()->school_id)->get();

                $data['exam_result'] = $exam_result->toArray();
                $data['pass_marks'] = 0;

                return ApiBaseMethod::sendResponse($data, null);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function updatePassowrdStoreApi(Request $request)
    {
        try {
            $user = User::find($request->id);

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {

                if (Hash::check($request->current_password, $user->password)) {

                    $user->password = Hash::make($request->new_password);
                    $result = $user->save();
                    $msg = "Password Changed Successfully ";
                    return ApiBaseMethod::sendResponse(null, $msg);
                } else {
                    $msg = "You Entered Wrong Current Password";
                    return ApiBaseMethod::sendError(null, $msg);
                }
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function leaveApply(Request $request)
    {
        try {
            $user = Auth::user();

            if ($user) {
                $my_leaves = SmLeaveDefine::where('role_id', $user->role_id)->where('user_id', $user->id)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
                $apply_leaves = SmLeaveRequest::where('staff_id', $user->id)->where('role_id', $user->role_id)->where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
                $leave_types = SmLeaveDefine::whereHas('leaveType')->where('role_id', $user->role_id)->where('user_id', $user->id)->where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            } else {
                $my_leaves = SmLeaveDefine::where('role_id', $request->role_id)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
                $apply_leaves = SmLeaveRequest::where('role_id', $request->role_id)->where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
                $leave_types = SmLeaveDefine::whereHas('leaveType')->where('role_id', $request->role_id)->where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            }

            return view('backEnd.student_leave.apply_leave', compact('apply_leaves', 'leave_types', 'my_leaves'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function leaveStore(Request $request)
    {
        $request->validate([
            'apply_date' => "required",
            'leave_type' => "required",
            'leave_from' => 'required|before_or_equal:leave_to',
            'leave_to' => "required",
            'attach_file' => "sometimes|nullable|mimes:pdf,doc,docx,jpg,jpeg,png,txt",
        ]);
        try {
            $maxFileSize = SmGeneralSettings::first('file_size')->file_size;
            $file = $request->file('attach_file');
            $fileSize = filesize($file);
            $fileSizeKb = ($fileSize / 1000000);
            if ($fileSizeKb >= $maxFileSize) {
                Toastr::error('Max upload file size ' . $maxFileSize . ' Mb is set in system', 'Failed');
                return redirect()->back();
            }
            $input = $request->all();
            $fileName = "";
            if ($request->file('attach_file') != "") {
                $file = $request->file('attach_file');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/leave_request/', $fileName);
                $fileName = 'public/uploads/leave_request/' . $fileName;
            }
            $user = auth()->user();
            if ($user) {
                $login_id = $user->id;
                $role_id = $user->role_id;
            } else {
                $login_id = $request->login_id;
                $role_id = $request->role_id;
            }
            $leaveDefine = SmLeaveDefine::with('leaveType:id')->find($request->leave_type, ['id', 'type_id']);
            $apply_leave = new SmLeaveRequest();
            $apply_leave->staff_id = $login_id;
            $apply_leave->role_id = $role_id;
            $apply_leave->apply_date = date('Y-m-d', strtotime($request->apply_date));
            $apply_leave->leave_define_id = $request->leave_type;
            $apply_leave->type_id = $leaveDefine->leaveType->id;
            $apply_leave->leave_from = date('Y-m-d', strtotime($request->leave_from));
            $apply_leave->leave_to = date('Y-m-d', strtotime($request->leave_to));
            $apply_leave->approve_status = 'P';
            $apply_leave->reason = $request->reason;
            $apply_leave->file = $fileName;
            $apply_leave->academic_id = getAcademicId();
            $apply_leave->school_id = auth()->user()->school_id;
            $result = $apply_leave->save();

            $studentInfo = SmStudent::where('user_id', auth()->user()->id)->first();
            $data['to_date'] = $apply_leave->leave_to;
            $data['name'] = $apply_leave->user->full_name;
            $data['from_date'] = $apply_leave->leave_from;
            $data['class'] = $studentInfo->studentRecord->class->class_name;
            $data['section'] = $studentInfo->studentRecord->section->section_name;
            $this->sent_notifications('Leave_Apply', [$studentInfo->user_id], $data, ['Student']);

            // try {
            //     $data['name'] = $user->full_name;
            //     $data['email'] = $user->email;
            //     $data['role'] = $user->roles->name;
            //     $data['apply_date'] = $request->apply_date;
            //     $data['leave_from'] = $request->leave_from;
            //     $data['leave_to'] = $request->leave_to;
            //     $data['reason'] = $request->reason;
            //     send_mail($user->email, $user->full_name, "leave_applied", $data);

            //     $user = User::where('role_id', 1)->first();
            //     $notification = new SmNotification;
            //     $notification->user_id = $user->id;
            //     $notification->role_id = $user->role_id;
            //     $notification->date = date('Y-m-d');
            //     $notification->message = app('translator')->get('leave.leave_request');
            //     $notification->school_id = Auth::user()->school_id;
            //     $notification->academic_id = getAcademicId();
            //     $notification->save();
            //     Notification::send($user, new LeaveApprovedNotification($notification));
            // } catch (\Exception $e) {
            //     Log::info($e->getMessage());
            // }

            if ($result) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function pendingLeave(Request $request)
    {
        try {
            $apply_leaves = SmLeaveRequest::with('leaveDefine', 'student')->where([['active_status', 1], ['approve_status', 'P']])->where('staff_id', auth()->id())->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();


            return view('backEnd.student_leave.pending_leave', compact('apply_leaves'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentLeaveEdit(request $request, $id)
    {
        try {
            $user = Auth::user();
            if ($user) {
                if ($user->role_id == 2) {
                    $my_leaves = SmLeaveDefine::where('user_id', $user->id)->get();
                    $apply_leaves = SmLeaveRequest::where('role_id', $user->role_id)->where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
                    $leave_types = SmLeaveDefine::where('role_id', $user->role_id)->where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
                } else {
                    $my_leaves = SmLeaveDefine::where('role_id', $user->role_id)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
                    $apply_leaves = SmLeaveRequest::where('role_id', $user->role_id)->where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
                    $leave_types = SmLeaveDefine::where('role_id', $user->role_id)->where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
                }
            } else {
                $my_leaves = SmLeaveDefine::where('role_id', $request->role_id)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
                $apply_leaves = SmLeaveRequest::where('role_id', $request->role_id)->where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
                $leave_types = SmLeaveDefine::where('role_id', $request->role_id)->where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            }
            $apply_leave = SmLeaveRequest::find($id);
            return view('backEnd.student_leave.apply_leave', compact('apply_leave', 'apply_leaves', 'leave_types', 'my_leaves'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $request->validate([
            'apply_date' => "required",
            'leave_type' => "required",
            'leave_from' => 'required|before_or_equal:leave_to',
            'leave_to' => "required",
            'file' => "sometimes|nullable|mimes:pdf,doc,docx,jpg,jpeg,png",
        ]);
        try {
            $maxFileSize = SmGeneralSettings::first('file_size')->file_size;
            $file = $request->file('attach_file');
            $fileSize = filesize($file);
            $fileSizeKb = ($fileSize / 1000000);
            if ($fileSizeKb >= $maxFileSize) {
                Toastr::error('Max upload file size ' . $maxFileSize . ' Mb is set in system', 'Failed');
                return redirect()->back();
            }
            $fileName = "";
            if ($request->file('attach_file') != "") {
                $apply_leave = SmLeaveRequest::find($request->id);
                if (file_exists($apply_leave->file)) {
                    unlink($apply_leave->file);
                }

                $file = $request->file('attach_file');
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/leave_request/', $fileName);
                $fileName = 'public/uploads/leave_request/' . $fileName;
            }

            $user = Auth()->user();
            if ($user) {
                $login_id = $user->id;
                $role_id = $user->role_id;
            } else {
                $login_id = $request->login_id;
                $role_id = $request->role_id;
            }

            $apply_leave = SmLeaveRequest::find($request->id);
            $apply_leave->staff_id = $login_id;
            $apply_leave->role_id = $role_id;
            $apply_leave->apply_date = date('Y-m-d', strtotime($request->apply_date));
            $apply_leave->leave_define_id = $request->leave_type;
            $apply_leave->leave_from = date('Y-m-d', strtotime($request->leave_from));
            $apply_leave->leave_to = date('Y-m-d', strtotime($request->leave_to));
            $apply_leave->approve_status = 'P';
            $apply_leave->reason = $request->reason;
            if ($fileName != "") {
                $apply_leave->file = $fileName;
            }
            $result = $apply_leave->save();
            if ($result) {
                Toastr::success('Operation successful', 'Success');
                return redirect('student-apply-leave');
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function DownlodTimeline($file_name)
    {
        try {
            $file = public_path() . '/uploads/student/timeline/' . $file_name;
            if (file_exists($file)) {
                return Response::download($file);
            } else {
                Toastr::error('File not found', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function DownlodDocument($file_name)
    {
        try {
            $file = public_path() . '/uploads/homework/' . $file_name;
            if (file_exists($file)) {
                return Response::download($file);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function DownlodContent($file_name)
    {
        try {
            $file = public_path() . '/uploads/upload_contents/' . $file_name;
            if (file_exists($file)) {
                return Response::download($file);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function DownlodStudentDocument($file_name)
    {
        try {
            $file = public_path() . '/uploads/student/document/' . $file_name;
            if (file_exists($file)) {
                return Response::download($file);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function downloadHomeWorkContent($id, $student_id)
    {
        try {
            $student = SmStudent::where('id', $student_id)->first();
            if (Auth::user()->role_id == 2) {
                $student = SmStudent::where('user_id', $student_id)->first();
            }
            $hwContent = SmUploadHomeworkContent::where('student_id', $student->id)->where('homework_id', $id)->get();
            // $file_array= json_decode($hwContent->file, true);
            // $files = $file_array;
            // $zipname = 'Homework_Content_'.time().'.zip';
            // $zip = new ZipArchive;
            // $zip->open($zipname, ZipArchive::CREATE);
            //     foreach ($files as $file) {
            //         $zip->addFile($file);
            //     }
            // $zip->close();
            // header('Content-Type: application/zip');
            // header('Content-disposition: attachment; filename='.$zipname);
            // header('Content-Length: ' . filesize($zipname));
            // readfile($zipname);
            // File::delete($zipname);

            $file_paths = [];
            foreach ($hwContent as $key => $files_row) {
                $only_files = json_decode($files_row->file);
                foreach ($only_files as $second_key => $upload_file_path) {
                    $file_paths[] = $upload_file_path;
                }
            }
            $zip_file_name = str_replace(' ', '_', time() . '.zip'); // Name of our archive to download

            $new_file_array = [];
            foreach ($file_paths as $key => $file) {

                $file_name_array = explode('/', $file);
                $file_original = $file_name_array[array_key_last($file_name_array)];
                $new_file_array[$key]['path'] = $file;
                $new_file_array[$key]['name'] = $file_original;
            }
            $public_dir = public_path('uploads/homeworkcontent');
            $zip = new ZipArchive;
            if ($zip->open($public_dir . '/' . $zip_file_name, ZipArchive::CREATE) === true) {
                // Add Multiple file
                foreach ($new_file_array as $key => $file) {
                    $zip->addFile($file['path'], @$file['name']);
                }
                $zip->close();
            }

            $zip_file_url = asset('public/uploads/homeworkcontent/' . $zip_file_name);
            session()->put('homework_zip_file', $zip_file_name);

            return Redirect::to($zip_file_url);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function qrcode_view()
    {
        return view('backEnd.studentPanel.attendance_qrcode');
    }

    public function qrcode(Request $request)
    {
        try {
            $code = AttendanceCode::where('code', $request->code)->whereDate('date', Carbon::now())->first();
            if (!isset($code)) {
                return response()->json(['message' => 'Operation Failed'], 422);
            }

            $student = SmStudent::where('user_id', auth()->id())->first();
            $studentRecord = StudentRecord::where('student_id', $student->id)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->where('class_id', $code->class_id)
                ->where('section_id', $code->section_id)
                ->where('session_id', $student->session_id)
                ->first();
            $record_id = $studentRecord ? $studentRecord->id : null;

            if ($code->type == 'subject') {
                $attendance = SmSubjectAttendance::where('student_id', $student->id)
                    ->where('subject_id', $code->subject_id)
                    ->where('attendance_date', $code->date)
                    ->where('class_id', $code->class_id)
                    ->where('section_id', $code->section_id)
                    ->where('student_record_id', $record_id)
                    ->where('academic_id', getAcademicId())
                    ->where('school_id', Auth::user()->school_id)
                    ->first();

                if (isset($attendance)) {
                    return response()->json(['message' => 'Attendance already submitted']);
                }

                $attendance = new SmSubjectAttendance();
                $attendance->student_record_id = $record_id;
                $attendance->subject_id = $code->subject_id;
                $attendance->student_id = $student->id;
                $attendance->class_id = $code->class_id;
                $attendance->section_id = $code->section_id;
                $attendance->attendance_type = 'P';
                $attendance->notes = '';
                $attendance->school_id = Auth::user()->school_id;
                $attendance->academic_id = getAcademicId();
                $attendance->attendance_date = $code->date;
                $attendance->save();
            }

            if ($code->type == 'class') {
                $attendance = SmStudentAttendance::where('student_id', $student->id)->where('attendance_date', date('Y-m-d', strtotime($request->date)))
                    ->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->first();

                if (isset($attendance)) {
                    return response()->json(['message' => 'Attendance already submitted']);
                }

                $attendance = new SmStudentAttendance();
                $attendance->student_id = $student->id;
                $attendance->attendance_type = 'P';
                $attendance->notes = '';
                $attendance->attendance_date = $code->date;
                $attendance->school_id = Auth::user()->school_id;
                $attendance->academic_id = getAcademicId();
                $attendance->student_record_id = $record_id;
                $attendance->class_id = $code->class_id;
                $attendance->section_id = $code->section_id;
                $attendance->save();

                // if ($request->attendance[$student] == 'P') {
                //     $student_info = SmStudent::find($student);
                //     $compact['attendance_date'] = $attendance->attendance_date;
                //     $compact['user_email'] = $student_info->email;
                //     $compact['student_id'] = $student_info;
                //     @send_sms($student_info->mobile, 'student_attendance', $compact);

                //     $compact['user_email'] = @$student_info->parents->guardians_email;
                //     @send_sms(@$student_info->parents->guardians_mobile, 'student_attendance_for_parent', $compact);
                // }
            }


            // $data['class_id'] = gv($student, 'class');
            // $data['section_id'] = gv($student, 'section');
            // $data['subject'] = $attendance->subject->subject_name;
            // $records = $this->studentRecordInfo($data['class_id'], $data['section_id'])->pluck('studentDetail.user_id');
            // $this->sent_notifications('Subject_Wise_Attendance', $records, $data, ['Student', 'Parent']);
            return response()->json(['message' => 'Operation successful']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Operation Failed'], 500);
        }
    }
}
