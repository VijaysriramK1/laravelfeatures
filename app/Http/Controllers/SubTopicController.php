<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\SmClass;
use App\SmStaff;
use App\SmSection;
use App\SmSubject;
use App\YearCheck;
use App\SmAssignSubject;
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
use Modules\Lesson\Entities\LessonPlanTopic;
use Modules\University\Repositories\Interfaces\UnCommonRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SubTopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
    }

    public function index()
    {
        try {
            $data = $this->loadTopic();
            return view('sub_topic', compact('data'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function store(Request $request)
    {
        // dd($request);

        try {
             $input = $request->all();
           
             $rules = [
                'class' => 'required',
                'subject' => 'required',
                'section' => 'required',
                'lesson' => 'required',
                'topic' => 'required',
            ];

            $validator = Validator::make($input,$rules);
            if($validator->fails()){
              return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $class_id = $request->class;
            $section_id = $request->section;
            $subject_id = $request->subject;
            $lesson_id =  $request->lesson;
            $topic_id =  $request->topic;
            $subtopicArray = $request->sub_topic ?? [];
            $maxMarksArray =  $request->max_marks ?? [];
            $avgMarksArray =  $request->avg_marks ?? [];
            $imageArray =  $request->image ?? [];

            $length = min(
                count($subtopicArray),
                count($maxMarksArray),
                count($avgMarksArray),
                // count($imageArray)
            );

            for ($i = 0; $i < $length; $i++) {

                Log::info('ForLoop', ['Count' => $i]);

                $SubtopicDetail = new LessonPlanTopic;
                $sub_topic_title = $subtopicArray[$i] ?? NULL;
                $max_mark = $maxMarksArray[$i] ?? NULL;
                $avg_mark = $avgMarksArray[$i] ?? NULL;
                $image = isset($imageArray[$i]) ? $imageArray[$i] : NULL;


                $SubtopicDetail->sub_topic_title = $sub_topic_title;
                $SubtopicDetail->max_marks = $max_mark;
                $SubtopicDetail->avg_marks = $avg_mark;

                if ($image) {
                    $imageFile =  $image;
                    $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
                    $imagePath = $imageFile->move(public_path('uploads/sub_topic_images'), $imageName);
                    $SubtopicDetail->image = 'uploads/sub_topic_images/' . $imageName;
                }


                $SubtopicDetail->class_id = $class_id;
                $SubtopicDetail->section_id =  $section_id;
                $SubtopicDetail->subject_id =  $subject_id;
                $SubtopicDetail->lesson_id = $lesson_id;
                $SubtopicDetail->topic_id =  $topic_id;
                $SubtopicDetail->created_at = YearCheck::getYear() . '-' . date('m-d h:i:s');
                $SubtopicDetail->school_id = Auth::user()->school_id;
                $SubtopicDetail->academic_id = getAcademicId();
                $SubtopicDetail->save();

                // dd($SubtopicDetail);
            }

            DB::commit();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            // Log::error('Failed', ['error' => $e->getMessage()]);
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $data = $this->loadTopic();

            $subTopic = SmLessonTopicDetail::findOrFail($id);
            $subTopicDetails = LessonPlanTopic::where('topic_id', $id)->get();

            $data['classes'] = SmClass::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();
            $data['sections'] = SmSection::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();
            $data['subjects'] = SmSubject::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();
            $data['lessons'] = SmLesson::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();
            $data['topics'] = SmLessonTopicDetail::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $data['subTopic'] = $subTopic;
            $data['subTopicDetails'] = $subTopicDetails;
            $subTopicData = LessonPlanTopic::where('topic_id', $id)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->first();

            // Get the topic_id directly from subTopicData
            $topic_id = $subTopicData->topic_id;

            if (moduleStatusCheck('University')) {
                $interface = App::make(UnCommonRepositoryInterface::class);
                $data += $interface->getCommonData($subTopic);
            }

            return view('sub_topic_edit', $data, compact('subTopicData', 'topic_id'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function updateSubtopic(Request $request)
    {
        try {
            $input = $request->all();
            $rules = [
                'class' => 'required',
                'subject' => 'required',
                'section' => 'required',
                'lesson' => 'required',
                'topic' => 'required',
                'sub_topic.*' => 'string|max:255',
                'max_marks.*' => 'nullable|numeric',
                'avg_marks.*' => 'nullable|numeric',
                'image.*' => 'nullable|image',
            ];

           $messages = [
            'max_marks.*.numeric' => 'Must be a number',
            'avg_marks.*.numeric' => 'Must be a number',
           ];

            $validator = Validator::make($input,$rules,$messages);
            if($validator->fails()){
              return redirect()->back()->withErrors($validator)->withInput();
            }


            $class_id = $request->class;
            $section_id = $request->section;
            $subject_id = $request->subject;
            $lesson_id = $request->lesson;
            $topic_id = $request->topic;
            $subtopicArray = $request->sub_topic ?? [];
            $maxMarksArray = $request->max_marks ?? [];
            $avgMarksArray = $request->avg_marks ?? [];
            $imageArray = $request->image ?? [];
            $topicDetailIdArray = $request->topic_detail_id ?? [];

            $length = min(
                count($subtopicArray),
                count($maxMarksArray),
                count($avgMarksArray),
            );

            for ($i = 0; $i < $length; $i++) {
                $topic_detail_id = $request->topic_detail_id[$i];
                $subtopicDetail = LessonPlanTopic::find($topicDetailIdArray[$i]);

                if (!$subtopicDetail) {
                    continue; // Skip if subtopic not found
                }

                $sub_topic_title = $subtopicArray[$i] ?? null;
                $max_mark = $maxMarksArray[$i] ?? null;
                $avg_mark = $avgMarksArray[$i] ?? null;
                $image = $imageArray[$i] ?? null;

                $subtopicDetail->sub_topic_title = $sub_topic_title;
                $subtopicDetail->max_marks = $max_mark;
                $subtopicDetail->avg_marks = $avg_mark;

                if ($subtopicDetail->image) {
                    Storage::delete('public/' . $subtopicDetail->image);
                }

                if ($image) {
                    $imageFile = $image;
                    $imageName = time() . '.' . $imageFile->getClientOriginalName();
                    $imagePath = $imageFile->move(public_path('uploads/sub_topic_images'), $imageName);
                    $subtopicDetail->image = 'uploads/sub_topic_images/' . $imageName;
                }

                $subtopicDetail->class_id = $class_id;
                $subtopicDetail->section_id = $section_id;
                $subtopicDetail->subject_id = $subject_id;
                $subtopicDetail->lesson_id = $lesson_id;
                $subtopicDetail->topic_id = $topic_id;
                $subtopicDetail->school_id = Auth::user()->school_id;
                $subtopicDetail->academic_id = getAcademicId();
                $subtopicDetail->save();
            }

            Toastr::success('Operation successful', 'Success');
            return redirect('/sub-topic');
        } catch (\Exception $e) {
            // Log::error('Failed', ['error' => $e->getMessage()]);
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function subtopicdelete(Request $request)
    {
        $id = $request->id;

        $subTopicData = LessonPlanTopic::where('topic_id', $id)->get();
        if ($subTopicData) {
            foreach ($subTopicData as $subTopic) {
                LessonPlanTopic::destroy($subTopic->id);
                if ($subTopic->image) {
                    Storage::delete('public/' . $subTopic->image);
                }
            }
        }

        $topicDetail = SmLessonTopicDetail::where('id', $id)->get();
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
        return redirect('/sub-topic');
    }
    public function deletesubTopic(Request $request)
    {


        $id = $request->id;

        $subTopicData = LessonPlanTopic::where('topic_id', $id)->get();

        if ($subTopicData) {
            foreach ($subTopicData as $subTopic) {
                LessonPlanTopic::destroy($subTopic->id);
                if ($subTopic->image) {
                    Storage::delete('public/' . $subTopic->image);
                }
            }
        }


        SmLessonTopicDetail::destroy($id);
        $topicDetail = LessonPlanner::where('topic_detail_id', $id)->get();
        if ($topicDetail) {
            foreach ($topicDetail as $data) {
                LessonPlanner::destroy($data->id);
            }
        }

        Toastr::success('Operation successful', 'Success');
        return redirect('/sub-topic');
    }


    public function getAllSubTopicsAjax(Request $request)
    {
        if ($request->ajax()) {
            // Query to get subtopics with their related data
            $subTopics = SmLessonTopicDetail::with('subTopics', 'topics')
                ->whereHas('subTopics')
                ->get();

            return datatables()->of($subTopics)
                ->addIndexColumn()
                ->addColumn('class_name', function ($row) {
                    return $row->topicName->class->class_name ?? 'N/A';
                })
                ->addColumn('section_name', function ($row) {
                    return $row->topicName->section->section_name ?? 'N/A';
                })
                ->addColumn('subject_name', function ($row) {
                    return $row->topicName->subject->subject_name ?? 'N/A';
                })
                ->addColumn('lesson_title', function ($row) {
                    return $row->topicName->lesson->lesson_title ?? 'N/A';
                })
                ->addColumn('topics_name', function ($row) {
                    if (!empty($row->subTopics) && isset($row->subTopics[0]->topic_id)) {
                        $topic = SmLessonTopicDetail::where('id', $row->subTopics[0]->topic_id)->first();
                        return $topic ? $topic->topic_title : 'N/A';
                    }
                    return 'N/A';
                })
                ->addColumn('sub_topic_detail', function ($row) {
                    $topics_name = "";
                    $totalSubtopics = count($row->subTopics);
                    foreach ($row->subTopics as $index => $topicData) {
                        $topics_name .= "<div style='padding-bottom: 5px; margin-bottom: 5px;padding-top:5px;'>";
                        $topics_name .= strtoupper($topicData->sub_topic_title);
                        // $topics_name .= strtoupper($topicData->sub_topic_title) . " (" . strtoupper($topicData->max_marks) . " " . strtoupper($topicData->avg_marks) . ")";
                        $topics_name .= "</div>";

                        if ($totalSubtopics > 1 && $index + 1 < $totalSubtopics) {
                            $topics_name .= "<div style='border-bottom: 1px solid #ddd;'></div>";
                        }
                    }
                    return $topics_name;
                })
                ->addColumn('avg_and_max_marks_detail', function ($row) {
                    $avg_and_max_marks_detail = "";
                    $total_avg_and_max_marks = count($row->subTopics);
                    foreach ($row->subTopics as $index => $avg_and_max_Data) {
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
                //     $topics_title = $row->subTopics;
                //     foreach ($topics_title as $topicData) {
                //         $max_marks_detail .= $topicData->max_marks ?? 'N/A';
                //         if (($topics_title->last()) != $topicData) {
                //             $max_marks_detail .= ',';
                //         }
                //     }
                //     return $max_marks_detail;
                // })
                // ->addColumn('avg_marks_detail', function ($row) {
                //     $avg_marks_detail = "";
                //     $topics_title = $row->subTopics;
                //     foreach ($topics_title as $topicData) {
                //         $avg_marks_detail .= $topicData->avg_marks ?? 'N/A';
                //         if (($topics_title->last()) != $topicData) {
                //             $avg_marks_detail .= ',';
                //         }
                //     }
                //     return $avg_marks_detail;
                // })
                // ->addColumn('image_detail', function ($row) {
                //     $image_detail = "";
                //     $image = $row->subTopics;
                //     foreach ($image as $imageData) {
                //         if ($imageData->image) {
                //             $image_detail .= "<div style='padding-bottom: 5px; margin-bottom: 5px;padding-top:5px;'>";
                //             $image_detail .= '<img src="' . asset('public/' . $imageData->image) . '" onerror="this.src=\'' . asset('public/backEnd/img/default.png') . '\'" width="50" height="50" style="margin-right:5px;"/>';
                //             $image_detail .= "</div>";
                //         }
                //         else {
                //             $image_detail .= "<div style='padding-bottom: 5px; margin-bottom: 5px;padding-top:5px;'>";
                //             $image_detail .= '<img src="' . asset('public/backEnd/img/default.png') . '" width="50" height="50" style="margin-right:5px;"/>';
                //             $image_detail .= "</div>";
                //         }
                //         if (($image->last()) != $imageData) {
                //             $image_detail .= '  ';
                //         }
                //     }
                //     return $image_detail;
                // })
                ->addColumn('image_detail', function ($row) {
                    $image_detail = "";
                    $image = $row->subTopics;

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

                    $subtopic_id = $row->subTopics;


                    $btn = '<div class="dropdown CRM_dropdown">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">' . __('common.select') . '</button>
                    <div class="dropdown-menu dropdown-menu-right">';
                    // Add edit and delete options
                    // if (userPermission('sub-topic-edit')) {
                    // foreach ($subtopic_id as $subtopic) {
                    //     if ($subtopic->id) {
                    //         $btn .= '<a class="dropdown-item" href="' . route('sub-topic-edit', $subtopic->id) . '">' . __('common.edit') . '</a>';
                    //     }

                    // }
                    $btn .= '<a class="dropdown-item" href="' . route('sub-topic-edit', $row->id) . '">' . __('common.edit') . '</a>';
                    // }
                    // if (userPermission('topic-delete')) {
                    $btn .= '<a onclick="deleteTopic(' . $row->id . ');" class="dropdown-item" data-id="' . $row->id . '">' . __('common.delete') . '</a>';

                    $btn .= '<a class="dropdown-item" href="' . route('subtopics', $row->id) . '">' . __('common.clone')  . '</a>';                    
                    // }
                    $btn .= '</div></div>';
                    return $btn;
                })
                ->rawColumns(['action', 'sub_topic_detail', 'image_detail', 'avg_and_max_marks_detail'])
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

    // <!------------------------------------------------------------- LESSON BASED TOPICS ------------------------------------------------------>
    public function ajaxSelectTopic(Request $request)
    {
        try {

            $topic_all = SmLessonTopicDetail::where('lesson_id', $request->lesson_id)
                ->distinct('topic_id')
                ->get();

            $topics = [];

            foreach ($topic_all as $topic) {
                $topics[] = $topic;
            }

            return response()->json([$topics]);
        } catch (\Exception $e) {

            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    // <!------------------------------------------------------------- LESSON BASED TOPICS ------------------------------------------------------>

    public function SubTopicEditImageDelete(Request $request)
    {
        $id = $request->id;
        $subtopicDetail = LessonPlanTopic::where('id', $id)->get();
        if ($subtopicDetail) {
            foreach ($subtopicDetail as $data) {
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
            return response()->json(['success' => true, 'message' => 'Image Not deleted.']);
        }

    }

}
