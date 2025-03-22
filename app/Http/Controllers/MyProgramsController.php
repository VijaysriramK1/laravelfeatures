<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\SmSubject;
use App\tableList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\Admin\Academics\SmSubjectRequest;
use App\SmAssignClassTeacher;
use App\SmAssignSubject;
use App\SmClass;
use App\SmClassRoutineUpdate;
use App\SmClassSection;
use App\SmSection;
use App\SmStaff;
use App\Jobs\Staff\SubjectJob;
use App\SmStudent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Lesson\Entities\LessonPlanTopic;
use Modules\Lesson\Entities\SmLessonTopic;
use Modules\Lesson\Entities\SmLessonTopicDetail;

class MyProgramsController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
        // User::checkAuth();
    }

    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $smstaff = SmStaff::where('user_id', Auth::user()->id)->first();
            $teacherId = $user->role_id == 4 ? $smstaff->id : $request->get('teacher');
            $classes = collect();
            $classSections = collect();
            $subjectCounts = collect();
            $subjects = collect();

            if ($teacherId) {
                $assignedClasses = SmAssignSubject::where('active_status', 1)
                    ->where('academic_id', getAcademicId())
                    ->whereHas('teacher', function ($q) use ($teacherId) {
                        $q->where('teacher_id', $teacherId);
                    })
                    ->with(['class', 'section'])
                    ->get();

                $classes = $assignedClasses->pluck('class')->unique('id');

                $classSections = $assignedClasses->groupBy('class_id')
                    ->map(function ($items) {
                        return $items->pluck('section')->unique('id');
                    });

                $subjectCounts = $assignedClasses->where('is_active', 4)->groupBy(function ($item) {
                    return $item->class_id . '-' . $item->section_id;
                })->map(function ($items) {
                    return $items->count();
                });

                $subjects = SmAssignSubject::whereHas('teacher', function ($q) use ($teacherId) {
                    $q->where('teacher_id', $teacherId);
                })->with(['subject', 'lesson'])->orderBy('id', 'DESC')->get();
            } elseif ($user->role_id == 2) {
                $student = SmStudent::where('user_id', $user->id)->first();

                $classRecords = $student->getClassRecord()->get();

                if ($classRecords->isEmpty()) {
                    Toastr::error('No class records found for the student', 'Error');
                    return redirect()->back();
                }

                $classes = collect();
                $classSections = collect();
                $subjects = collect();

                foreach ($classRecords as $record) {
                    $classId = $record->class_id;
                    $sectionId = $record->section_id;

                    $class = SmClass::find($classId);
                    $section = SmSection::find($sectionId);

                    $classes->push($class);
                    $classSections->put($classId, collect([$section]));
                    $count = SmAssignSubject::where('class_id', $classId)
                        ->where('section_id', $sectionId)
                        ->where('is_active', 4)
                        ->count();

                    $subjectCounts->put("$classId-$sectionId", $count);

                    $classSubjects = SmAssignSubject::where('class_id', $classId)
                        ->where('section_id', $sectionId)
                        ->with(['subject', 'lesson'])
                        ->orderBy('id', 'DESC')
                        ->get();

                    $subjects->put($classId . '-' . $sectionId, $classSubjects);
                }

                $teachers = SmStaff::where('school_id', $user->school_id)
                    ->where('role_id', 4)
                    ->get();
            } else {
                $classes = SmClass::where('active_status', 1)
                    ->where('academic_id', getAcademicId())
                    ->where('school_id', $user->school_id)
                    ->with(['classSection', 'classSectionAll'])
                    ->get();

                $classSections = $classes->mapWithKeys(function ($class) {
                    return [$class->id => $class->classSectionAll];
                });

                foreach ($classes as $class) {
                    foreach ($class->classSectionAll as $section) {
                        $classSubjects = SmAssignSubject::where('class_id', $class->id)
                            ->where('section_id', $section->id)
                            ->where('is_active', 4)
                            ->with(['subject', 'lesson'])
                            ->get();

                        $subjectCounts->put($class->id . '-' . $section->id, $classSubjects->count());
                        $subjects = $subjects->concat($classSubjects);
                    }
                }

                $subjects = SmAssignSubject::with(['subject', 'lesson'])->orderBy('id', 'DESC')->get();
            }

            // return response()->json([$subjects]);

            $teachers = SmStaff::where('school_id', $user->school_id)
                ->where('role_id', 4)
                ->get();

            return view('programs.my_programs', compact('classes', 'classSections', 'subjects', 'teachers', 'teacherId', 'user', 'subjectCounts'));
        } catch (\Exception $e) {
            Toastr::error('Operation failed', 'Failed');
            return redirect()->back();
            // dd($e);
        }
    }

    public function getSubject(Request $request, $classId, $sectionId)
    {
        try {
            $user = Auth::user();
            $smstaff = SmStaff::where('user_id', Auth::user()->id)->first();
            $teacherId = $user->role_id == 4 ? $smstaff->id : $request->get('teacher');

            if ($teacherId) {
                $assign_subjects = SmAssignSubject::where('class_id', $classId)
                    ->whereHas('teacher', function ($query) use ($teacherId) {
                        $query->where('teacher_id', $teacherId);
                    })
                    ->when($sectionId, function ($query) use ($sectionId) {
                        $query->where('section_id', $sectionId);
                    })
                    ->with([
                        'subject',
                        'subject.lessons' => function ($query) use ($classId, $sectionId) {
                            $query->where('class_id', $classId)
                                ->where('section_id', $sectionId);
                        },
                        'subject.lessons.topics' => function ($query) {
                            $query->with('subTopics');
                        }
                    ])
                    ->orderBy('id', 'DESC')
                    ->get();
            } else {
                $assign_subjects = SmAssignSubject::where('class_id', $classId)
                    ->when($sectionId, function ($query) use ($sectionId) {
                        $query->where('section_id', $sectionId);
                    })
                    ->with([
                        'subject',
                        'subject.lessons' => function ($query) use ($classId, $sectionId) {
                            $query->where('class_id', $classId)
                                ->where('section_id', $sectionId);
                        },
                        'subject.lessons.topics' => function ($query) {
                            $query->with('subTopics');
                        }
                    ])
                    ->orderBy('id', 'DESC')
                    ->get();
            }

            if ($assign_subjects->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No subjects found for the selected class and section.',
                ]);
            }

            $subjects = $assign_subjects->map(function ($assign_subject) use ($classId, $sectionId) {
                $request_subject = $assign_subject;
                $subject = $assign_subject->subject;
                $lessonCount = $subject->lessons->count();
                $topicCount = $subject->lessons->flatMap->topics->count();

                $totalSubTopicCount = $subject->lessons->flatMap(function ($lesson) {
                    return $lesson->topics->flatMap->subTopics;
                })->count();

                $subject->lessons = $subject->lessons->map(function ($lesson) use ($subject) {
                    return [
                        'id' => $lesson->id,
                        'lesson_title' => $lesson->lesson_title,
                        'completion_status' => $lesson->completion_status,
                        'due_date' => $lesson->due_date,
                        'description' => $lesson->description,
                        'topics' => $lesson->topics->map(function ($topic) use ($subject) {
                            return [
                                'id' => $topic->id,
                                'topic_title' => $topic->topic_title,
                                'completed_status' => $topic->completed_status,
                                'completed_date' => $topic->competed_date,
                                'image' => $topic->image,
                                'avg_marks' => $topic->avg_marks,
                                'max_marks' => $topic->max_marks,
                                'subject_id' => $subject->id,
                                'sub_topics' => $topic->subTopics->map(function ($subTopic) use ($subject) {
                                    return [
                                        'id' => $subTopic->id,
                                        'sub_topic_title' => $subTopic->sub_topic_title,
                                        'image' => $subTopic->image,
                                        'completed_status' => $subTopic->completed_status,
                                        'completed_date' => $subTopic->competed_date,
                                        'avg_marks' => $subTopic->avg_marks,
                                        'max_marks' => $subTopic->max_marks,
                                        'subject_id' => $subject->id,
                                    ];
                                })
                            ];
                        }),
                    ];
                });

                return [
                    'id' => $subject->id,
                    'class_id' => $request_subject->class_id,
                    'section_id' => $request_subject->section_id,
                    'subject_name' => $subject->subject_name,
                    'subject_code' => $subject->subject_code,
                    'image' => $subject->image,
                    'lessons' => $subject->lessons,
                    'lesson_count' => $lessonCount,
                    'topic_count' => $topicCount,
                    'sub_topic_count' => $totalSubTopicCount,
                    'duration' => $subject->duration,
                    'duration_type' => $subject->duration_type,
                    'active_status' => $subject->active_status,
                    'is_active' => $request_subject->is_active,
                    'notes' => $request_subject->notes,
                    'teacher' => $request_subject->teacher
                ];
            });

            $today = now()->toDateString();
            $classRoutines = SmClassRoutineUpdate::where('class_id', $classId)
                ->where('section_id', $sectionId)
                ->when($teacherId, function ($query) use ($teacherId) {
                    $query->where('teacher_id', $teacherId);
                })
                ->where(function ($query) use ($today) {
                    $query->whereDate('start_date', '<=', $today)
                        ->whereDate('end_date', '>=', $today);
                })
                ->with(['teacherDetail', 'class', 'section', 'subject'])
                ->orderBy('start_time')
                ->get();

            return response()->json([
                'status' => 'success',
                'subjects' => $subjects,
                'class_routines' => $classRoutines
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Operation Failed',
                'error' => $e->getMessage()
            ]);
        }
    }


    public function updateStatus(Request $request)
    {
        $request->validate([
            'topicId' => 'required|integer',
            'status' => 'required|in:1,2',
        ]);

        $topic = SmLessonTopicDetail::findOrFail($request->topicId);
        $topic->completed_status = $request->status;
        if ($request->status == 1) {
            $topic->competed_date = now();
        } else {
            $topic->competed_date = null;
        }
        $topic->save();

        if ($request->status == 2) {
            LessonPlanTopic::where('topic_id', $request->topicId)->update(['completed_status' => 2]);
        }

        return response()->json(['success' => true]);
    }

    public function updateSubtopicStatus(Request $request)
    {
        $request->validate([
            'subTopicId' => 'required|integer',
            'status' => 'required|in:1,2',
        ]);

        $subTopic = LessonPlanTopic::findOrFail($request->subTopicId);
        $subTopic->completed_status = $request->status;
        if ($request->status == 1) {
            $subTopic->competed_date = now();
        } else {
            $subTopic->competed_date = null;
        }
        $subTopic->save();

        return response()->json(['success' => true]);
    }

    public function updateStatusBulk(Request $request)
    {
        $topicId = $request->input('topicId');
        $status = $request->input('status');

        $subtopics = LessonPlanTopic::where('topic_id', $topicId)->get();
        foreach ($subtopics as $subtopic) {
            $subtopic->completed_status = $status;
            $subtopic->save();
        }

        return response()->json(['message' => 'Subtopics status updated successfully']);
    }

    public function updateSubjectStatus(Request $request)
    {
        
        try {
            $subject = SmAssignSubject::with('teacher')
                ->where('subject_id', $request->subject_id)
                ->where('class_id', $request->class_id)
                ->where('section_id', $request->section_id)
                ->first();

            if ($subject) {
                $subject->is_active = $request->status;
                $subject->notes = $request->notes ?? null;
                $subject->save();
                if ($request->status == 4) {
                    $roles = [1, 5]; 
                    foreach ($roles as $role) {
                        sendNotification("Subject Unlock Request Received", '/program/my-programs?teacher=' . $subject->teacher_id, $role, $role);
                    }
                } elseif ($request->status == 5) {
                    sendNotification("Subject Unlock Request Rejected", '/program/my-programs', $subject->teacher->user_id, 4);
                }
                $job = (new SubjectJob($subject, $request->status))->delay(Carbon::now()->addSeconds(10));
                dispatch($job);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No subjects found for the update.',
                ]);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation failed', 'Failed');
            return redirect()->back();
        }
    }
}
