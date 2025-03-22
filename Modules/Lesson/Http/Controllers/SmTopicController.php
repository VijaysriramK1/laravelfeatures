<?php

namespace Modules\Lesson\Http\Controllers;

use DataTables;
use App\SmClass;
use App\SmStaff;
use App\SmSection;
use App\SmSubject;
use App\YearCheck;
use App\SmAssignSubject;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Modules\Lesson\Entities\SmLesson;
use Illuminate\Support\Facades\Config;
use Modules\Lesson\Entities\LessonPlanner;
use Modules\Lesson\Entities\SmLessonTopic;
use Modules\Lesson\Entities\SmLessonTopicDetail;
use Modules\University\Repositories\Interfaces\UnCommonRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SmTopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
    }

    public function index()
    {
        try {

            $data = $this->loadTopic();
            $data['is_sub_topic_enabled'] = SmLessonTopicDetail::pluck('is_sub_topic_enabled')->first();
            if (moduleStatusCheck('University')) {
                return view('university::topic.topic', $data);
            } else {
                return view('lesson::topic.topic', $data);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        // dd($request);
        $input = $request->all();
        if (moduleStatusCheck('University')) {

            $rules =  [
                'un_session_id' => 'required',
                'un_faculty_id' => 'sometimes|nullable',
                'un_department_id' => 'required',
                'un_academic_id' => 'required',
                'un_semester_id' => 'required',
                'un_semester_label_id' => 'required',
                'un_subject_id' => 'required',
                'lesson' => 'required',
            ];
        } else {

            $rules =  [
                'class' => 'required',
                'subject' => 'required',
                'section' => 'required',
                'lesson' => 'required',
            ];
        }

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        DB::beginTransaction();
        if (moduleStatusCheck('University')) {
            $is_duplicate = SmLessonTopic::where('school_id', Auth::user()->school_id)
                ->where('un_session_id', $request->un_session_id)
                ->when($request->un_faculty_id, function ($query) use ($request) {
                    $query->where('un_faculty_id', $request->un_faculty_id);
                })->where('un_department_id', $request->un_department_id)
                ->where('un_academic_id', $request->un_academic_id)
                ->where('un_semester_id', $request->un_department_id)
                ->where('un_semester_label_id', $request->un_academic_id)
                ->where('un_subject_id', $request->un_subject_id)
                ->where('lesson_id', $request->lesson)
                ->first();
        } else {
            $is_duplicate = SmLessonTopic::where('school_id', Auth::user()->school_id)
                ->where('class_id', $request->class)
                ->where('lesson_id', $request->lesson)
                ->where('section_id', $request->section)
                ->where('subject_id', $request->subject)
                ->where('academic_id', getAcademicId())
                ->first();
        }


        $is_sub_topic_enabled = $request->sub_topic_enabled;

        // dd($is_sub_topic_enabled);

        if ($is_duplicate) {

            $topicArray = $request->topic ?? [];
            $cgpaArray = $request->cgpa ?? [];
            $unitArray = $request->unit ?? [];
            $is_mark_enabled_array = $request->cgpa_unit_enabled ?? [];

            $maxMarksArray =  $request->max_marks ?? [];
            $avgMarksArray = $request->avg_marks ?? [];
            $imageArray =  $request->image ?? [];



            if ($is_sub_topic_enabled == 0) {
                $length = min(
                    count($topicArray),
                    count($cgpaArray),
                    count($unitArray),
                    count($maxMarksArray),
                    count($avgMarksArray),
                    count($imageArray),
                    count($is_mark_enabled_array)
                );
            } else {
                $length = min(
                    count($topicArray),
                    count($cgpaArray),
                    count($unitArray),
                    count($is_mark_enabled_array)
                );
            }


            // $length = count($request->topic);
            for ($i = 0; $i < $length; $i++) {

                $topicDetail = new SmLessonTopicDetail;
                $topic_title = $request->topic[$i] ?? NULL;
                $cgpa = $request->cgpa[$i] ?? NULL;
                $unit = $request->unit[$i] ?? NULL;
                $is_mark = $request->cgpa_unit_enabled[$i] ?? NULL;
                $is_subtopic = $request->sub_topic_enabled[$i] ?? NULL;

                $max_mark = $maxMarksArray[$i] ?? NULL;
                $avg_mark = $avgMarksArray[$i] ?? NULL;
                $image = $imageArray[$i] ?? NULL;


                $topicDetail->topic_id = $is_duplicate->id;
                $topicDetail->topic_title = $topic_title;
                $topicDetail->cgpa = $cgpa;
                $topicDetail->unit = $unit;
                $topicDetail->max_marks = $max_mark;
                $topicDetail->avg_marks = $avg_mark;
                $topicDetail->is_sub_topic_enabled = $is_subtopic;
                $topicDetail->is_mark_enabled = $is_mark;

                if ($image) {
                    $imageFile =  $image;
                    $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
                    $imagePath = $imageFile->move(public_path('uploads/topic_images'), $imageName);
                    $topicDetail->image = 'uploads/topic_images/' . $imageName;
                }

                $topicDetail->lesson_id = $request->lesson;
                $topicDetail->school_id = Auth::user()->school_id;
                if (moduleStatusCheck('University')) {
                    $topicDetail->un_academic_id = getAcademicId();
                } else {
                    $topicDetail->academic_id = getAcademicId();
                }
                $topicDetail->save();
            }
            DB::commit();
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } else {
            try {
                $smTopic = new SmLessonTopic;
                $smTopic->class_id = $request->class;
                $smTopic->section_id = $request->section;
                $smTopic->subject_id = $request->subject;
                $smTopic->lesson_id = $request->lesson;
                $smTopic->created_at = YearCheck::getYear() . '-' . date('m-d h:i:s');
                $smTopic->school_id = Auth::user()->school_id;
                if (moduleStatusCheck('University')) {
                    $common = App::make(UnCommonRepositoryInterface::class);
                    $common->storeUniversityData($smTopic, $request);
                } else {
                    $smTopic->academic_id = getAcademicId();
                }
                $smTopic->save();
                $smTopic_id = $smTopic->id;


                $topicArray = $request->topic ?? [];
                $cgpaArray = $request->cgpa ?? [];
                $unitArray = $request->unit ?? [];
                $is_mark_enabled_array = $request->cgpa_unit_enabled ?? [];

                $maxMarksArray =  $request->max_marks ?? [];
                $avgMarksArray = $request->avg_marks ?? [];
                $imageArray =  $request->image ?? [];


                if ($is_sub_topic_enabled == 0) {
                    $length = min(
                        count($topicArray),
                        count($cgpaArray),
                        count($unitArray),
                        count($maxMarksArray),
                        count($avgMarksArray),
                        count($imageArray),
                        count($is_mark_enabled_array)
                    );
                } else {
                    $length = min(
                        count($topicArray),
                        count($cgpaArray),
                        count($unitArray),
                        count($is_mark_enabled_array)
                    );
                }


                // $length = count($request->topic);
                for ($i = 0; $i < $length; $i++) {

                    $topicDetail = new SmLessonTopicDetail;
                    $topic_title = $request->topic[$i] ?? NULL;
                    $cgpa = $request->cgpa[$i] ?? NULL;
                    $unit = $request->unit[$i] ?? NULL;
                    $is_mark = $request->cgpa_unit_enabled[$i] ?? NULL;
                    $is_subtopic = $request->sub_topic_enabled[$i] ?? NULL;

                    $max_mark = $maxMarksArray[$i] ?? NULL;
                    $avg_mark = $avgMarksArray[$i] ?? NULL;
                    $image = $imageArray[$i] ?? NULL;


                    $topicDetail->topic_id = $smTopic_id;
                    $topicDetail->topic_title = $topic_title;
                    $topicDetail->cgpa = $cgpa;
                    $topicDetail->unit = $unit;
                    $topicDetail->max_marks = $max_mark;
                    $topicDetail->avg_marks = $avg_mark;
                    $topicDetail->is_sub_topic_enabled = $is_subtopic;
                    $topicDetail->is_mark_enabled = $is_mark;

                    if ($image) {
                        $imageFile =  $image;
                        $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
                        $imagePath = $imageFile->move(public_path('uploads/topic_images'), $imageName);
                        $topicDetail->image = 'uploads/topic_images/' . $imageName;
                    }

                    $topicDetail->lesson_id = $request->lesson;
                    $topicDetail->school_id = Auth::user()->school_id;
                    if (!moduleStatusCheck('University')) {
                        $topicDetail->academic_id = getAcademicId();
                    }
                    $topicDetail->save();
                }
                DB::commit();

                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } catch (\Exception $e) {
                Log::error('Failed', ['error' => $e->getMessage()]);
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
                // dd($e);
            }
        }
    }

    public function edit($id)
    {

        try {
            $data = $this->loadTopic();
            $data['topic'] = SmLessonTopic::where('academic_id', getAcademicId())
                ->where('id', $id)->where('school_id', Auth::user()->school_id)->first();
            $data['lessons'] = SmLesson::where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            $data['topicDetails'] = SmLessonTopicDetail::where('topic_id', $data['topic']->id)->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)->get();
            $data['is_sub_topic_enabled'] = SmLessonTopicDetail::pluck('is_sub_topic_enabled')->first();
            if (moduleStatusCheck('University')) {

                $request = [
                    'semester_id' => $data['topic']->un_semester_id,
                    'academic_id' => $data['topic']->un_academic_id,
                    'session_id' => $data['topic']->un_session_id,
                    'department_id' => $data['topic']->un_department_id,
                    'faculty_id' => $data['topic']->un_faculty_id,
                    'semester_label_id' => $data['topic']->un_semester_label_id,
                    'subject_id' => $data['topic']->un_subject_id,
                ];
                $interface = App::make(UnCommonRepositoryInterface::class);

                $data += $interface->getCommonData($data['topic']);
                return view('university::topic.edit_topic', $data);
            }
            return view('lesson::topic.editTopic', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function updateTopic(Request $request)
    {
       
        try {
            $input = $request->all();
            // $rules =  [
            //     'cgpa.*' => 'nullable|numeric|max:10',
            //     'unit.*' => 'nullable|regex:/^%$/',
            //     'max_marks.*' => 'nullable|numeric|max:100',
            //     'avg_marks.*' => 'nullable|numeric|max:90',
            // ];

            // $messages = [
            //     'cgpa.*.numeric' => 'Must be a number',
            //     'unit.*' => 'Allowed % Only...',
            //     'max_marks.*.numeric' => 'Must be a number',
            //     'avg_marks.*.numeric' => 'Must be a number',
            // ];
            // $validator = Validator::make($input, $rules, $messages);
            // if ($validator->fails()) {
            //     return redirect()->back()->withInput()->withErrors($validator->messages());
            // }

            $topicArray = $request->topic ?? [];
            $cgpaArray = $request->cgpa ?? [];
            $unitArray = $request->unit ?? [];
            $maxMarksArray = $request->max_marks ?? [];
            $avgMarksArray = $request->avg_marks ?? [];
            $imageArray = $request->image ?? [];
            $is_sub_topic_enabled = $request->sub_topic_enabled;
            $is_mark_enabled_array = $request->cgpa_unit_enabled ?? [];
            $topicDetailIdArray = $request->topic_detail_id ?? [];

            if ($is_sub_topic_enabled == 0) {
                $length = min(
                    count($topicArray),
                    count($cgpaArray),
                    count($unitArray),
                    count($maxMarksArray),
                    count($avgMarksArray),
                    // count($imageArray),
                    count($is_mark_enabled_array)
                );
            } else {
                $length = min(
                    count($topicArray),
                    count($cgpaArray),
                    count($unitArray),
                    count($is_mark_enabled_array)
                );
            }

            for ($i = 0; $i < $length; $i++) {

                $topic_detail_id = $request->topic_detail_id[$i];
                $topicDetail = SmLessonTopicDetail::find($topic_detail_id);

                $topic_title = $request->topic[$i] ?? NULL;
                $cgpa = $request->cgpa[$i] ?? NULL;
                $unit = $request->unit[$i] ?? NULL;
                $max_mark = $request->max_marks[$i] ?? NULL;
                $avg_mark = $request->avg_marks[$i] ?? NULL;
                $image = $request->image[$i] ?? NULL;
                $is_mark = $request->cgpa_unit_enabled[$i] ?? NULL;
                $is_subtopic = $request->sub_topic_enabled[$i] ?? NULL;



                $topicDetail->topic_title = $topic_title;
                $topicDetail->cgpa = $cgpa;
                $topicDetail->unit = $unit;
                $topicDetail->max_marks = $max_mark;
                $topicDetail->avg_marks = $avg_mark;
                $topicDetail->is_sub_topic_enabled = $is_subtopic;
                $topicDetail->is_mark_enabled = $is_mark;

                if ($topicDetail->image) {
                    Storage::delete('public/public/' . $topicDetail->image);
                }

                if ($image) {
                    $imageFile =  $image;
                    $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
                    $imagePath = $imageFile->move(public_path('uploads/topic_images'), $imageName);
                    $topicDetail->image = 'uploads/topic_images/' . $imageName;
                }

                $topicDetail->school_id = Auth::user()->school_id;
                $topicDetail->academic_id = getAcademicId();
                $topicDetail->save();
            }

            Toastr::success('Operation successful', 'Success');
            return redirect('/lesson/topic');
        } catch (\Exception $e) {
            Log::error('failed', ['error' => $e->getMessage()]);
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function topicdelete(Request $request)
    {
        $id = $request->id;
        $topic = SmLessonTopic::find($id);
        $topic->delete();
        $topicDetail = SmLessonTopicDetail::where('topic_id', $id)->get();
        if ($topicDetail) {
            foreach ($topicDetail as $data) {
                SmLessonTopicDetail::destroy($data->id);
                LessonPlanner::where('topic_detail_id', $data->id)->get();
                if ($data->image) {
                    Storage::delete('public/public/' . $data->image);
                }
            }
        }

        $topicLessonPlan = LessonPlanner::where('topic_id', $id)->get();
        if ($topicLessonPlan) {
            foreach ($topicLessonPlan as $topic_data) {
                LessonPlanner::destroy($topic_data->id);
            }
        }

        Toastr::success('Operation successful', 'Success');
        return redirect()->route('lesson.topic');
    }
    public function deleteTopicTitle($id)
    {
        SmLessonTopicDetail::destroy($id);
        $topicDetail = LessonPlanner::where('topic_detail_id', $id)->get();
        if ($topicDetail) {
            foreach ($topicDetail as $data) {
                LessonPlanner::destroy($data->id);
            }
        }

        Toastr::success('Operation successful', 'Success');
        return redirect()->back();
    }


    public function getAllTopicsAjax(Request $request)
    {

        if ($request->ajax()) {
            if (Auth::user()->role_id == 4) {
                $subjects = SmAssignSubject::select('subject_id')->where('teacher_id', Auth()->user()->staff->id)->get();
                $topics = SmLessonTopic::with('lesson', 'class', 'section', 'subject')->whereIn('subject_id', $subjects)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            } else {
                $topics = SmLessonTopic::with('lesson', 'class', 'section', 'subject')->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            }
            return Datatables::of($topics)
                ->addIndexColumn()
                ->addColumn('topics_name', function ($row) {
                    $topics_name = "";
                    $totalTopics = count($row->topics);
                    foreach ($row->topics as $index => $topicData) {
                        $topics_name .= "<div style='padding-bottom: 5px; margin-bottom: 5px;padding-top:5px;'>";
                        $topics_name .= strtoupper($topicData->topic_title) . " (" . strtoupper($topicData->cgpa) . " " . strtoupper($topicData->unit) . ")";
                        $topics_name .= "</div>";

                        if ($totalTopics > 1 && $index + 1 < $totalTopics) {
                            $topics_name .= "<div style='border-bottom: 1px solid #ddd;'></div>";
                        }
                    }
                    return $topics_name;
                })

                ->addColumn('cgpa_detail', function ($row) {
                    $cgpa_detail = "";
                    $cgpa = $row->topics;
                    foreach ($cgpa as $cgpaData) {
                        $cgpa_detail .= $cgpaData->cgpa;

                        if (($cgpa->last()) != $cgpaData) {
                            $cgpa_detail .= ',';
                        }
                    }
                    return $cgpa_detail;
                })
                ->addColumn('unit_detail', function ($row) {
                    $unit_detail = "";
                    $unit = $row->topics;
                    foreach ($unit as $unitData) {
                        $unit_detail .= $unitData->unit;
                        if (($unit->last()) != $unitData) {
                            $unit_detail .= ',';
                        }
                    }
                    return $unit_detail;
                })
                ->addColumn('avg_and_max_marks_detail', function ($row) {
                    $avg_and_max_marks_detail = "";
                    $total_avg_and_max_marks = count($row->topics);
                    foreach ($row->topics as $index => $avg_and_max_Data) {
                        $avg_and_max_marks_detail .= "<div style='padding-bottom: 5px; margin-bottom: 5px;padding-top:5px;'>";
                        $avg_and_max_marks_detail .= (isset($avg_and_max_Data->avg_marks) && isset($avg_and_max_Data->max_marks)) ? ($avg_and_max_Data->avg_marks . " / " . $avg_and_max_Data->max_marks) : 'N/A';
                        $avg_and_max_marks_detail .= "</div>";

                        if ($total_avg_and_max_marks > 1 && $index + 1 < $total_avg_and_max_marks) {
                            $avg_and_max_marks_detail .= "<div style='border-bottom: 1px solid #ddd;'></div>";
                        }
                    }
                    return $avg_and_max_marks_detail;
                })
                // ->addColumn('max_marks_detail', function ($row) {
                //     $max_marks_detail = "";
                //     $max_mark = $row->topics;
                //     foreach ($max_mark as $max_markData) {
                //         $max_marks_detail .= $max_markData->max_marks;
                //         if (($max_mark->last()) != $max_markData) {
                //             $max_marks_detail .= ',';
                //         }
                //     }
                //     return $max_marks_detail;
                // })
                // ->addColumn('avg_marks_detail', function ($row) {
                //     $avg_marks_detail = "";
                //     $avg_mark = $row->topics;
                //     foreach ($avg_mark as $avg_markData) {
                //         $avg_marks_detail .= $avg_markData->avg_marks;
                //         if (($avg_mark->last()) != $avg_markData) {
                //             $avg_marks_detail .= ',';
                //         }
                //     }
                //     return $avg_marks_detail;
                // })
                ->addColumn('image_detail', function ($row) {
                    $image_detail = "";
                    $image = $row->topics;

                    foreach ($image as $imageData) {
                        $filePath = 'public/' . $imageData->image;
                        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                       
                        switch (strtolower($extension)) {
                            case 'pdf':
                                $defaultIcon = asset('public/uploads/settings/pdf-blue.png');
                                break;
                            case 'csv':
                                $defaultIcon = asset('public/uploads/settings/csv-fileblue.png');
                                break;
                            case 'doc':
                                $defaultIcon = asset('public/uploads/settings/doc-blue.png');
                                break;
                            case 'docx':
                                $defaultIcon = asset('public/uploads/settings/docx-file-blue.png');
                                break;
                            default:
                                $defaultIcon = asset('public/backEnd/img/default.png'); 
                                break;
                        }
                
                        $image_detail .= "<div style='padding-bottom: 5px; margin-bottom: 5px;padding-top:5px;'>";

                        if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png'])) {
                            
                            $image_detail .= '<img src="' . asset('public/' . $imageData->image) . '" onerror="this.src=\'' . asset('public/backEnd/img/default.png') . '\'" width="50" height="50" style="margin-right:5px;"/>';
                        } else {
                            
                            $image_detail .= '<img src="' . $defaultIcon . '" width="50" height="50" style="margin-right:5px;"/>';
                        }
                        $image_detail .= "</div>";
                
                        if (($image->last()) != $imageData) {
                            $image_detail .= '  ';
                        }
                    }
                    return $image_detail;
                })
                
                
                ->addColumn('action', function ($row) {

                    $btn = '<div class="dropdown CRM_dropdown">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">' . app('translator')->get('common.select') . '</button>

                    <div class="dropdown-menu dropdown-menu-right">' .
                        // Edit option
                        (userPermission('topic-edit') ? '<a class="dropdown-item" href="' . route('topic-edit', $row->id) . '">' . app('translator')->get('common.edit') . '</a>' : '') .

                        // Delete option
                        (userPermission('topic-delete') ?
                            (Config::get('app.app_sync')
                                ? '<span data-toggle="tooltip" title="Disabled For Demo"><a class="dropdown-item" href="#">' . app('translator')->get('common.disable') . '</a></span>'
                                : '<a onclick="deleteTopic(' . $row->id . ');" class="dropdown-item" href="#" data-id="' . $row->id . '">' . app('translator')->get('common.delete') . '</a>'
                            ) : ''
                        ) .

                       '<a class="dropdown-item" href="' . route('TopicClone', $row->id) . '">' . app('translator')->get('common.clone') . '</a>'  .

                        '</div>
                </div>';

                    return $btn;
                })
                ->rawColumns(['action', 'topics_name', 'image_detail', 'avg_and_max_marks_detail'])
                ->make(true);
        }
    }


    public function loadTopic()
    {
        $teacher_info = SmStaff::where('user_id', Auth::user()->id)->first();
        if (Auth::user()->role_id == 4) {
            $subjects = SmAssignSubject::select('subject_id')->where('teacher_id', $teacher_info->id)->get();
            $data['topics'] = SmLessonTopic::with('lesson', 'class', 'section', 'subject')->whereIn('subject_id', $subjects)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
        } else {
            $data['topics'] = SmLessonTopic::with('lesson', 'class', 'section', 'subject')->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
        }

        if (!teacherAccess()) {
            $data['classes'] = SmClass::where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
        } else {
            $data['classes'] = SmAssignSubject::where('teacher_id', $teacher_info->id)
                ->join('sm_classes', 'sm_classes.id', 'sm_assign_subjects.class_id')
                ->where('sm_assign_subjects.active_status', 1)
                ->where('sm_assign_subjects.school_id', Auth::user()->school_id)
                ->where('sm_assign_subjects.academic_id', getAcademicId())
                ->select('sm_classes.id', 'class_name')
                ->groupBy('sm_classes.id')
                ->get();
        }
        $data['subjects'] = SmSubject::get();
        $data['sections'] = SmSection::get();
        return $data;
    }


    public function EnableSubTopic(Request $request)
    {
        $status = $request->status;
        $newlyCreatedTopicIds = $request->newly_created_topic_ids;

        // Ensure newly created topic IDs is an array or empty array if not provided
        if (!is_array($newlyCreatedTopicIds)) {
            $newlyCreatedTopicIds = [];
        }

        // Validate that the status is either 0 or 1
        if ($status == 1) {
            SmLessonTopicDetail::whereIn('id', $newlyCreatedTopicIds)
                ->update(['is_sub_topic_enabled' => 1]);
        } elseif ($status == 0) {
            SmLessonTopicDetail::whereIn('id', $newlyCreatedTopicIds)
                ->update(['is_sub_topic_enabled' => 0]);
        } else {
            return response()->json(['status' => 'Invalid status'], 400);
        }

        return response()->json(['status' => 'Success'], 200);
    }


    public function TopicEditImageDelete(Request $request)
    {
        $id = $request->id;
        $topicDetail = SmLessonTopicDetail::where('id', $id)->get();
        if ($topicDetail) {
            foreach ($topicDetail as $data) {
                if ($data->image && file_exists(public_path($data->image))) {
                    unlink(public_path($data->image));
                }
                if ($data->image && Storage::exists('public/' . $data->image)) {
                    Storage::delete('public/' . $data->image);
                }
                $data->image = null;
                $data->save();

                return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
            }
            return response()->json(['success' => true, 'message' => 'Image Not deleted successfully.']);
        }

    }
}
