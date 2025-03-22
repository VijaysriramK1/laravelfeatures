<?php

namespace App\Http\Controllers\Programs;

use App\SmStaff;
use App\SmStudent;
use App\SmClassSection;
use App\SmClassTeacher;
use App\SmAssignSubject;
use App\SmAssignClassTeacher;
use App\Models\StudentRecord;
use App\SmClassRoutineUpdate;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Modules\Lesson\Entities\LessonPlanner;
use Modules\Lesson\Entities\LessonPlanTopic;
use Modules\Lesson\Entities\SmLessonTopicDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoutinesController extends Controller
{
    public function classWiseSectionsList()
    {
        if (Auth::user()->role_id == 2) {
            $check_student_details = SmStudent::where('user_id', Auth::user()->id)->where('school_id', Auth::user()->school_id)->first();
            $get_student_records = StudentRecord::where('student_id', $check_student_details->id)->where('school_id', Auth::user()->school_id)->first();

            if (!empty($get_student_records)) {
                $get_classwise_sections = SmClassSection::with('classname', 'sectionname')->where('class_id', $get_student_records->class_id)->where('section_id', $get_student_records->section_id)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            } else {
                $get_classwise_sections = '';
            }

            $blade_file_name = 'programs.routines.student_routine';
        } else if (Auth::user()->role_id == 4) {
            $check_staff_details = SmStaff::where('user_id', Auth::user()->id)->where('school_id', Auth::user()->school_id)->first();
            $get_staff_assigned_classes_sections = SmClassTeacher::where('teacher_id', $check_staff_details->id)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->pluck('assign_class_teacher_id');

            if ($get_staff_assigned_classes_sections->isNotEmpty()) {
                $get_classwise_sections = SmAssignClassTeacher::with('class', 'section')->where('school_id', Auth::user()->school_id)->where('academic_id', getAcademicId())->whereIn('id', $get_staff_assigned_classes_sections)->orderBy('class_id', 'asc')->orderBy('section_id', 'asc')->get();
            } else {
                $get_classwise_sections = '';
            }

            $blade_file_name = 'programs.routines.teacher_routine';
        } else {
            $check_classwise_sections = SmClassSection::with('classname', 'sectionname')->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->orderBy('class_id', 'asc')->orderBy('section_id', 'asc')->get();

            if ($check_classwise_sections->isNotEmpty()) {
                $get_classwise_sections = $check_classwise_sections;
            } else {
                $get_classwise_sections = '';
            }

            $blade_file_name = 'programs.routines.admin_routine';
        }

        return view($blade_file_name, compact('get_classwise_sections'));
    }

    public function classWiseSectionsDetailsDatatable(Request $request)
    {
        if (Auth::user()->role_id == 2) {

            $check_student_details = SmStudent::where('user_id', Auth::user()->id)->where('school_id', Auth::user()->school_id)->first();
            $get_student_records = StudentRecord::where('student_id', $check_student_details->id)->where('school_id', Auth::user()->school_id)->first();


            if ($request->ajax()) {
                if ($request->selected_class != '' && $request->selected_section != '') {
                    $data = SmClassRoutineUpdate::with('teacherDetail', 'subject')->where('class_id', $request->selected_class)->where('section_id', $request->selected_section)->where('school_id', Auth::user()->school_id)->orderBy('start_date', 'asc')->get();
                    $check_lesson_planner =  LessonPlanner::with('lessonName', 'topicName')->where('class_id', $request->selected_class)->where('section_id', $request->selected_section)->where('school_id', Auth::user()->school_id)->get();
                } else {
                    $get_first_data = SmClassSection::where('class_id', $get_student_records->class_id)->where('section_id', $get_student_records->section_id)->where('school_id', Auth::user()->school_id)->first();
                    $data = SmClassRoutineUpdate::with('teacherDetail', 'subject')->where('class_id', $get_first_data->class_id)->where('section_id', $get_first_data->section_id)->where('school_id', Auth::user()->school_id)->orderBy('start_date', 'asc')->get();
                    $check_lesson_planner =  LessonPlanner::with('lessonName', 'topicName')->where('class_id', $get_first_data->class_id)->where('section_id', $get_first_data->section_id)->where('school_id', Auth::user()->school_id)->get();
                }

                $rows = [];
                $days = [
                    'saturday' => [],
                    'sunday' => [],
                    'monday' => [],
                    'tuesday' => [],
                    'wednesday' => [],
                    'thursday' => [],
                    'friday' => []
                ];
            
                foreach ($data as $routine) {
                    $get_lesson_planner = $check_lesson_planner->where('routine_id', $routine->id)->first();

                    $completedDate = '--';

                    if ($get_lesson_planner) {
                        $completedDate = !empty($get_lesson_planner->completed_date) ? Carbon::parse($get_lesson_planner->completed_date)->format('d-m-Y') : '--';
                    }
                    
                    $routineHtml = "<div>" .
                    "Teacher: " . $routine->teacherDetail->first_name . " " . $routine->teacherDetail->last_name . "<br>" .
                    "Subject Name: " . (!empty($routine->subject->subject_name) ? $routine->subject->subject_name : '--') . "<br>" .
                    "Start Time: " . (!empty($routine->start_time) ? Carbon::parse($routine->start_time)->format('h:i A') : '--') . "<br>" .
                    "End Time: " . (!empty($routine->end_time) ? Carbon::parse($routine->end_time)->format('h:i A') : '--') . "<br>" .
                    "Start Date: " . (!empty($routine->start_date) ? Carbon::parse($routine->start_date)->format('d-m-Y') : '--') . "<br>" .
                    "End Date: " . (!empty($routine->end_date) ? Carbon::parse($routine->end_date)->format('d-m-Y') : '--') . "<br>" .
                    "Completed Date: " . $completedDate .
                    "</div>";         
                    switch ($routine->day) {
                        case 1:
                            $days['saturday'][] = $routineHtml;
                            break;
                        case 2:
                            $days['sunday'][] = $routineHtml;
                            break;
                        case 3:
                            $days['monday'][] = $routineHtml;
                            break;
                        case 4:
                            $days['tuesday'][] = $routineHtml;
                            break;
                        case 5:
                            $days['wednesday'][] = $routineHtml;
                            break;
                        case 6:
                            $days['thursday'][] = $routineHtml;
                            break;
                        case 7:
                            $days['friday'][] = $routineHtml;
                            break;
                    }
                }
            
                $maxRoutines = max(array_map('count', $days));
                for ($i = 0; $i < $maxRoutines; $i++) {
                    $row = [
                        'saturday' => isset($days['saturday'][$i]) ? $days['saturday'][$i] : '--',
                        'sunday' => isset($days['sunday'][$i]) ? $days['sunday'][$i] : '--',
                        'monday' => isset($days['monday'][$i]) ? $days['monday'][$i] : '--',
                        'tuesday' => isset($days['tuesday'][$i]) ? $days['tuesday'][$i] : '--',
                        'wednesday' => isset($days['wednesday'][$i]) ? $days['wednesday'][$i] : '--',
                        'thursday' => isset($days['thursday'][$i]) ? $days['thursday'][$i] : '--',
                        'friday' => isset($days['friday'][$i]) ? $days['friday'][$i] : '--'
                    ];
            
                    $rows[] = $row;
                }

                return DataTables::of($rows)
                ->addColumn('saturday', function ($row) {
                    return $row['saturday'];
                })
                ->addColumn('sunday', function ($row) {
                    return $row['sunday'];
                })
                ->addColumn('monday', function ($row) {
                    return $row['monday'];
                })
                ->addColumn('tuesday', function ($row) {
                    return $row['tuesday'];
                })
                ->addColumn('wednesday', function ($row) {
                    return $row['wednesday'];
                })
                ->addColumn('thursday', function ($row) {
                    return $row['thursday'];
                })
                ->addColumn('friday', function ($row) {
                    return $row['friday'];
                })
                ->rawColumns(['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'])
                ->with('status', 'success')
                ->make(true);
            }
        } else if (Auth::user()->role_id == 4) {

            $check_staff_details = SmStaff::where('user_id', Auth::user()->id)->where('school_id', Auth::user()->school_id)->first();

            if ($request->ajax()) {
                if ($request->selected_class != '' && $request->selected_section != '') {
                    $data = SmClassRoutineUpdate::with('subject')->where('class_id', $request->selected_class)->where('section_id', $request->selected_section)->where('teacher_id', $check_staff_details->id)->where('school_id', Auth::user()->school_id)->orderBy('start_date', 'asc')->get();
                    $check_lesson_planner =  LessonPlanner::with('lessonName', 'topicName')->where('class_id', $request->selected_class)->where('section_id', $request->selected_section)->where('school_id', Auth::user()->school_id)->get();
                } else {
                    $get_staff_assigned_classes_sections = SmClassTeacher::where('teacher_id', $check_staff_details->id)->where('school_id', Auth::user()->school_id)->pluck('assign_class_teacher_id');
                    $get_first_data = SmAssignClassTeacher::where('school_id', Auth::user()->school_id)->whereIn('id', $get_staff_assigned_classes_sections)->orderBy('class_id', 'asc')->orderBy('section_id', 'asc')->first();
                    $data = SmClassRoutineUpdate::with('subject')->where('class_id', $get_first_data->class_id)->where('section_id', $get_first_data->section_id)->where('teacher_id', $check_staff_details->id)->where('school_id', Auth::user()->school_id)->orderBy('start_date', 'asc')->get();
                    $check_lesson_planner =  LessonPlanner::with('lessonName', 'topicName')->where('class_id', $get_first_data->class_id)->where('section_id', $get_first_data->section_id)->where('school_id', Auth::user()->school_id)->get();
                }
                $rows = [];
                $days = [
                    'saturday' => [],
                    'sunday' => [],
                    'monday' => [],
                    'tuesday' => [],
                    'wednesday' => [],
                    'thursday' => [],
                    'friday' => []
                ];
            
                foreach ($data as $routine) {
                    $get_lesson_planner = $check_lesson_planner->where('routine_id', $routine->id)->first();

                    $completedDate = '--';

                    if ($get_lesson_planner) {
                        $completedDate = !empty($get_lesson_planner->completed_date) ? Carbon::parse($get_lesson_planner->completed_date)->format('d-m-Y') : '--';
                    }
                    
                    $routineHtml = "<div>" .
                    "Subject Name: " . (!empty($routine->subject->subject_name) ? $routine->subject->subject_name : '--') . "<br>" .
                    "Start Time: " . (!empty($routine->start_time) ? Carbon::parse($routine->start_time)->format('h:i A') : '--') . "<br>" .
                    "End Time: " . (!empty($routine->end_time) ? Carbon::parse($routine->end_time)->format('h:i A') : '--') . "<br>" .
                    "Start Date: " . (!empty($routine->start_date) ? Carbon::parse($routine->start_date)->format('d-m-Y') : '--') . "<br>" .
                    "End Date: " . (!empty($routine->end_date) ? Carbon::parse($routine->end_date)->format('d-m-Y') : '--') . "<br>" .
                    "Completed Date: " . $completedDate .
                    "</div>";         
                    switch ($routine->day) {
                        case 1:
                            $days['saturday'][] = $routineHtml;
                            break;
                        case 2:
                            $days['sunday'][] = $routineHtml;
                            break;
                        case 3:
                            $days['monday'][] = $routineHtml;
                            break;
                        case 4:
                            $days['tuesday'][] = $routineHtml;
                            break;
                        case 5:
                            $days['wednesday'][] = $routineHtml;
                            break;
                        case 6:
                            $days['thursday'][] = $routineHtml;
                            break;
                        case 7:
                            $days['friday'][] = $routineHtml;
                            break;
                    }
                }
            
                $maxRoutines = max(array_map('count', $days));
                for ($i = 0; $i < $maxRoutines; $i++) {
                    $row = [
                        'saturday' => isset($days['saturday'][$i]) ? $days['saturday'][$i] : '--',
                        'sunday' => isset($days['sunday'][$i]) ? $days['sunday'][$i] : '--',
                        'monday' => isset($days['monday'][$i]) ? $days['monday'][$i] : '--',
                        'tuesday' => isset($days['tuesday'][$i]) ? $days['tuesday'][$i] : '--',
                        'wednesday' => isset($days['wednesday'][$i]) ? $days['wednesday'][$i] : '--',
                        'thursday' => isset($days['thursday'][$i]) ? $days['thursday'][$i] : '--',
                        'friday' => isset($days['friday'][$i]) ? $days['friday'][$i] : '--'
                    ];
            
                    $rows[] = $row;
                }
                
                 return DataTables::of($rows)
                 ->addColumn('saturday', function ($row) {
                    return $row['saturday'];
                })
                ->addColumn('sunday', function ($row) {
                    return $row['sunday'];
                })
                ->addColumn('monday', function ($row) {
                    return $row['monday'];
                })
                ->addColumn('tuesday', function ($row) {
                    return $row['tuesday'];
                })
                ->addColumn('wednesday', function ($row) {
                    return $row['wednesday'];
                })
                ->addColumn('thursday', function ($row) {
                    return $row['thursday'];
                })
                ->addColumn('friday', function ($row) {
                    return $row['friday'];
                })
                ->rawColumns(['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'])
                ->with('status', 'success')
                ->make(true);
            }
        } else {
            if ($request->ajax()) {
                if ($request->selected_class != '' && $request->selected_section != '') {
                    $data = SmClassRoutineUpdate::with('teacherDetail', 'subject')
                        ->where('class_id', $request->selected_class)
                        ->where('section_id', $request->selected_section)
                        ->where('school_id', Auth::user()->school_id)
                        ->orderBy('start_date', 'asc')
                        ->get();

                    $check_lesson_planner = LessonPlanner::with('lessonName', 'topicName')->where('class_id', $request->selected_class)->where('section_id', $request->selected_section)->where('school_id', Auth::user()->school_id)->get();
                } else {
                    $get_first_data = SmClassSection::where('school_id', Auth::user()->school_id)
                        ->orderBy('class_id', 'asc')->orderBy('section_id', 'asc')->first();
                    $data = SmClassRoutineUpdate::with('teacherDetail', 'subject')
                        ->where('class_id', $get_first_data->class_id)
                        ->where('section_id', $get_first_data->section_id)
                        ->where('school_id', Auth::user()->school_id)
                        ->orderBy('start_date', 'asc')
                        ->get();

                    $check_lesson_planner =  LessonPlanner::with('lessonName', 'topicName')->where('class_id', $get_first_data->class_id)->where('section_id', $get_first_data->section_id)->where('school_id', Auth::user()->school_id)->get();
                }
        
                $rows = [];
                $days = [
                    'saturday' => [],
                    'sunday' => [],
                    'monday' => [],
                    'tuesday' => [],
                    'wednesday' => [],
                    'thursday' => [],
                    'friday' => []
                ];
            
                foreach ($data as $routine) {
                    $get_lesson_planner = $check_lesson_planner->where('routine_id', $routine->id)->first();

                    $completedDate = '--';

                    if ($get_lesson_planner) {
                        $completedDate = !empty($get_lesson_planner->completed_date) ? Carbon::parse($get_lesson_planner->completed_date)->format('d-m-Y') : '--';
                    }
                    
                    $routineHtml = "<div>" .
                    "Teacher: " . $routine->teacherDetail->first_name . " " . $routine->teacherDetail->last_name . "<br>" .
                    "Subject Name: " . (!empty($routine->subject->subject_name) ? $routine->subject->subject_name : '--') . "<br>" .
                    "Start Time: " . (!empty($routine->start_time) ? Carbon::parse($routine->start_time)->format('h:i A') : '--') . "<br>" .
                    "End Time: " . (!empty($routine->end_time) ? Carbon::parse($routine->end_time)->format('h:i A') : '--') . "<br>" .
                    "Start Date: " . (!empty($routine->start_date) ? Carbon::parse($routine->start_date)->format('d-m-Y') : '--') . "<br>" .
                    "End Date: " . (!empty($routine->end_date) ? Carbon::parse($routine->end_date)->format('d-m-Y') : '--') . "<br>" .
                    "Completed Date: " . $completedDate .
                    "</div>";         
                    switch ($routine->day) {
                        case 1:
                            $days['saturday'][] = $routineHtml;
                            break;
                        case 2:
                            $days['sunday'][] = $routineHtml;
                            break;
                        case 3:
                            $days['monday'][] = $routineHtml;
                            break;
                        case 4:
                            $days['tuesday'][] = $routineHtml;
                            break;
                        case 5:
                            $days['wednesday'][] = $routineHtml;
                            break;
                        case 6:
                            $days['thursday'][] = $routineHtml;
                            break;
                        case 7:
                            $days['friday'][] = $routineHtml;
                            break;
                    }
                }
            
                $maxRoutines = max(array_map('count', $days));
                for ($i = 0; $i < $maxRoutines; $i++) {
                    $row = [
                        'saturday' => isset($days['saturday'][$i]) ? $days['saturday'][$i] : '--',
                        'sunday' => isset($days['sunday'][$i]) ? $days['sunday'][$i] : '--',
                        'monday' => isset($days['monday'][$i]) ? $days['monday'][$i] : '--',
                        'tuesday' => isset($days['tuesday'][$i]) ? $days['tuesday'][$i] : '--',
                        'wednesday' => isset($days['wednesday'][$i]) ? $days['wednesday'][$i] : '--',
                        'thursday' => isset($days['thursday'][$i]) ? $days['thursday'][$i] : '--',
                        'friday' => isset($days['friday'][$i]) ? $days['friday'][$i] : '--'
                    ];
            
                    $rows[] = $row;
                }

                return DataTables::of($rows)
                    ->addColumn('saturday', function ($row) {
                        return $row['saturday'];
                    })
                    ->addColumn('sunday', function ($row) {
                        return $row['sunday'];
                    })
                    ->addColumn('monday', function ($row) {
                        return $row['monday'];
                    })
                    ->addColumn('tuesday', function ($row) {
                        return $row['tuesday'];
                    })
                    ->addColumn('wednesday', function ($row) {
                        return $row['wednesday'];
                    })
                    ->addColumn('thursday', function ($row) {
                        return $row['thursday'];
                    })
                    ->addColumn('friday', function ($row) {
                        return $row['friday'];
                    })
                    ->rawColumns(['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'])
                    ->with('status', 'success')
                    ->make(true);
            }
        }
        return abort(404);
    }

    public function subjectWiseTeacherList(Request $request)
    {
        $get_subjectwise_staff = SmAssignSubject::with('teacher')->where('class_id', $request->class_id)->where('section_id', $request->section_id)->where('subject_id', $request->subject_id)->where('school_id', Auth::user()->school_id)->get();
        return response()->json($get_subjectwise_staff);
    }

    public function lessonPlanOverviewSearch(Request $request)
    {
        if ($request->ajax()) {
            $check_routines = SmClassRoutineUpdate::where('class_id', $request->class_id)->where('section_id', $request->section_id)->where('subject_id', $request->subject_id)->where('teacher_id', $request->teacher_id)->where('school_id', Auth::user()->school_id)->get();
            $data = LessonPlanner::with('lessonName', 'topicName')->whereIn('routine_id', $check_routines->pluck('id'))->where('class_id', $request->class_id)->where('section_id', $request->section_id)->where('subject_id', $request->subject_id)->where('teacher_id', $request->teacher_id)->where('school_id', Auth::user()->school_id)->groupBy('routine_id')->get();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('lesson', function ($row) {
                    return $row->lessonName->lesson_title ?? '--';
                })
                ->addColumn('topic', function ($row) {
                    return $row->topicName->topic_title ?? '--';
                })

                ->addColumn('sub_topic', function ($row) {
                    $get_lesson_planner_details = LessonPlanner::where('routine_id', $row->routine_id)->get();
                    $get_subtopic_details = LessonPlanTopic::whereIn('id', $get_lesson_planner_details->pluck('sub_topic'))->get();

                    if ($get_subtopic_details->isEmpty()) {
                        $get_details = '';
                    } else {
                        $get_details[] = [
                            'sub_topic_name' => $get_subtopic_details->pluck('sub_topic_title')
                        ];
                    }
                    return $get_details;
                })
                ->addColumn('start_date', function ($row) use ($check_routines) {
                    $get_routines = $check_routines->where('id', $row->routine_id)->first();

                    if (!empty($get_routines)) {
                        if($get_routines->start_date != '' && $get_routines->start_date!= NULL){
                        return Carbon::parse($get_routines->start_date)->format('d-m-Y');
                        }else{
                            return '--';
                        }
                    } else {
                        return '--';
                    }
                })

                ->addColumn('end_date', function ($row) use ($check_routines) {
                    $get_routines = $check_routines->where('id', $row->routine_id)->first();

                    if (!empty($get_routines)) {
                        if($get_routines->end_date != '' && $get_routines->end_date != NULL){
                            return Carbon::parse($get_routines->end_date)->format('d-m-Y');
                        }else{
                            return '--';
                        }
                        
                    } else {
                        return '--';
                    }
                })

                ->addColumn('complete_date', function ($row) {
                    if($row->competed_date != '' && $row->competed_date != NULL){
                        return Carbon::parse($row->competed_date)->format('d-m-Y');
                    }else{
                        return '--'; 
                    }
                    
                })

                ->addColumn('status', function ($row) {
                    return $row->completed_status ?? '--';
                })

                ->addColumn('action', function ($row) {
                    return '<a type="button" class="popup-open-btn-cls" data-bs-toggle="modal" data-bs-target="#popupOpen" data-popup_id="' . $row->id . '" style="color: #7c32ff !important;"><i class="bi bi-pencil-square"></i></a>';
                })
                ->rawColumns(['action'])
                ->with('status', 'success')
                ->make(true);
        }

        return abort(404);
    }

    public function lessonPlanOverviewStatusUpdate(Request $request)
    {
        LessonPlanner::where('id', $request->id)->update([
            'competed_date' => Carbon::parse($request->completed_date)->format('Y-m-d'),
            'completed_status' => $request->status,
        ]);
        return response()->json(['status' => 'success', 'message' => 'Successfully Status Updated.']);
    }

    public function LessonPlanGetSubTopics(Request $request)
    {
        $sub_topics = LessonPlanTopic::where('topic_id', $request->topic_id)->get();
        return response()->json($sub_topics);
    }
  

    public function LessonPlanAdding(Request $request)
    {

        LessonPlanner::where('routine_id', $request->routine_id)->delete();

        if (empty($request->collect_details) || !is_array($request->collect_details)) {

            $add_details = new LessonPlanner();
    
            $add_details->class_id = $request->class_id;
            $add_details->section_id = $request->section_id;
            $add_details->subject_id = $request->subject_id;
            $add_details->lesson_detail_id = $request->lesson_id;
            $add_details->topic_detail_id = $request->topic_id;
            $add_details->teacher_id = $request->teacher_id;
            $add_details->routine_id = $request->routine_id;
            $add_details->school_id = Auth::user()->school_id;
            $add_details->note = $request->note ?? '';
            $add_details->save();
            
        } else {

            foreach ($request->collect_details as $val) {
                $add_details = new LessonPlanner();
    
                $add_details->class_id = $request->class_id;
                $add_details->section_id = $request->section_id;
                $add_details->subject_id = $request->subject_id;
                $add_details->lesson_detail_id = $request->lesson_id;
                $add_details->topic_detail_id = $request->topic_id;
                $add_details->teacher_id = $request->teacher_id;
                $add_details->routine_id = $request->routine_id;
                $add_details->school_id = Auth::user()->school_id;
                $add_details->note = $request->note ?? '';
                $add_details->sub_topic = $val['sub_topic_id'];
                $add_details->save();
            }

        }
        return response()->json(['status' => 'success', 'message' => 'Successfully updated.']);
    }

    public function calendarViewData()
    {
        if (Auth::user()->role_id == 2) {
            $check_student_details = SmStudent::where('user_id', Auth::user()->id)->where('school_id', Auth::user()->school_id)->first();
            $get_student_records = StudentRecord::where('student_id', $check_student_details->id)->where('school_id', Auth::user()->school_id)->first();
            $get_first_data = SmClassSection::where('class_id', $get_student_records->class_id)->where('section_id', $get_student_records->section_id)->where('school_id', Auth::user()->school_id)->first();
            $data = SmClassRoutineUpdate::with(['class', 'section', 'teacherDetail', 'subject'])->where('class_id', $get_first_data->class_id)->where('section_id', $get_first_data->section_id)->where('school_id', Auth::user()->school_id)->get();

            $get_data = $data->map(function ($routine) {

                $days = [
                    1 => 'Saturday',
                    2 => 'Sunday',
                    3 => 'Monday',
                    4 => 'Tuesday',
                    5 => 'Wednesday',
                    6 => 'Thursday',
                    7 => 'Friday'
                ];

                $completedDate = LessonPlanner::where('class_id', $routine->class_id)
                ->where('section_id', $routine->section_id)
                ->where('routine_id', $routine->id)
                ->first()->completed_date ?? null;

                return [
                    'class_section' => $routine->class->class_name . ' (' . $routine->section->section_name . ')',
                    'title' => $routine->subject->subject_name, 
                    'staff_name' => $routine->teacherDetail->first_name . ' ' . $routine->teacherDetail->last_name,  
                    'start' => $routine->start_date,
                    'end' => $routine->end_date,
                    'start_time' => $routine->start_time ? Carbon::parse($routine->start_time)->format('h:i A') : '--',  
                    'end_time' => $routine->end_time ? Carbon::parse($routine->end_time)->format('h:i A') : '--',
                    'day' => isset($days[$routine->day]) ? $days[$routine->day] : '--',
                    'completed_date' => $completedDate ? Carbon::parse($completedDate)->format('d-m-Y') : '--',
                ];
            });


        } else if (Auth::user()->role_id == 4) {
            $check_staff_details = SmStaff::where('user_id', Auth::user()->id)->where('school_id', Auth::user()->school_id)->first();
            $get_staff_assigned_classes_sections = SmClassTeacher::where('teacher_id', $check_staff_details->id)->where('school_id', Auth::user()->school_id)->pluck('assign_class_teacher_id');
            $get_first_data = SmAssignClassTeacher::where('school_id', Auth::user()->school_id)->whereIn('id', $get_staff_assigned_classes_sections)->orderBy('class_id', 'asc')->orderBy('section_id', 'asc')->first();
            $data = SmClassRoutineUpdate::with(['class', 'section', 'subject'])->where('class_id', $get_first_data->class_id)->where('section_id', $get_first_data->section_id)->where('teacher_id', $check_staff_details->id)->where('school_id', Auth::user()->school_id)->get();

            $get_data = $data->map(function ($routine) {

                $days = [
                    1 => 'Saturday',
                    2 => 'Sunday',
                    3 => 'Monday',
                    4 => 'Tuesday',
                    5 => 'Wednesday',
                    6 => 'Thursday',
                    7 => 'Friday'
                ];

                $completedDate = LessonPlanner::where('class_id', $routine->class_id)
                ->where('section_id', $routine->section_id)
                ->where('routine_id', $routine->id)
                ->first()->completed_date ?? null;
                
                return [
                    'class_section' => $routine->class->class_name . ' (' . $routine->section->section_name . ')',
                    'title' => $routine->subject->subject_name,   
                    'start' => $routine->start_date,
                    'end' => $routine->end_date,
                    'start_time' => $routine->start_time ? Carbon::parse($routine->start_time)->format('h:i A') : '--',  
                    'end_time' => $routine->end_time ? Carbon::parse($routine->end_time)->format('h:i A') : '--',
                    'day' => isset($days[$routine->day]) ? $days[$routine->day] : '--',
                    'completed_date' => $completedDate ? Carbon::parse($completedDate)->format('d-m-Y') : '--',
                ];
            });

        } else {
            $data = SmClassRoutineUpdate::with(['class', 'section', 'teacherDetail', 'subject'])->get();

            $get_data = $data->map(function ($routine) {

                $days = [
                    1 => 'Saturday',
                    2 => 'Sunday',
                    3 => 'Monday',
                    4 => 'Tuesday',
                    5 => 'Wednesday',
                    6 => 'Thursday',
                    7 => 'Friday'
                ];

                $completedDate = LessonPlanner::where('class_id', $routine->class_id)
                ->where('section_id', $routine->section_id)
                ->where('routine_id', $routine->id)
                ->first()->completed_date ?? null;

                return [
                    'class_section' => $routine->class->class_name . ' (' . $routine->section->section_name . ')',
                    'title' => $routine->subject->subject_name, 
                    'staff_name' => $routine->teacherDetail->first_name . ' ' . $routine->teacherDetail->last_name,  
                    'start' => $routine->start_date,
                    'end' => $routine->end_date,
                    'start_time' => $routine->start_time ? Carbon::parse($routine->start_time)->format('h:i A') : '--',  
                    'end_time' => $routine->end_time ? Carbon::parse($routine->end_time)->format('h:i A') : '--',
                    'day' => isset($days[$routine->day]) ? $days[$routine->day] : '--',
                    'completed_date' => $completedDate ? Carbon::parse($completedDate)->format('d-m-Y') : '--',
                ];
            });
        }
        
        return response()->json($get_data);
    }
}
