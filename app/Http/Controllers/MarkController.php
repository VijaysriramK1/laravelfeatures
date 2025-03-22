<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Response;
use App\Jobs\GenerateMarksheetPDFs;
use Carbon\Carbon;
use App\Models\SmStudentMark;
use App\Models\SmStudentMarkRegister;
use App\Models\StudentRecord;
use App\SmAssignClassTeacher;
use App\SmAssignSubject;
use App\SmClass;
use App\SmClassSection;
use App\SmSection;
use App\SmStaff;
use App\SmStudent;
use App\SmSubject;
use Brian2694\Toastr\Facades\Toastr;
use Dotenv\Validator;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use App\Jobs\Staff\MarkJob;
use App\Models\sm_student_mark_grand;
use App\Models\SmStudentMarkGrade;
use App\SmClassTeacher;
use App\SmMarksGrade;
use App\SmResultStore;
use App\YearCheck;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Lesson\Entities\LessonPlanTopic;
use Modules\Lesson\Entities\SmLesson;
use Modules\Lesson\Entities\SmLessonTopic;
use Modules\Lesson\Entities\SmLessonTopicDetail;
use ZipArchive;

class MarkController extends Controller
{
    public function index(Request $request)
    {

        $subtopicscount = 0;
        $topicscount = 0;
        $progress = 0;
        $userstudents = collect();

        $user = Auth::user();
        $subject = SmSubject::all();
        $classes = SmClass::get();

        $classId = $request->input('class_id');
        $sectionId = $request->input('section_id');
        $subjectId = $request->input('subject_id');

        $smstaff = SmStaff::where('user_id', $user->id)->first();

        $smstudents = collect();
        $assign_subjects = collect();


        $user = Auth::user();
        $smstaff = SmStaff::where('user_id', $user->id)->first();

        if ($user->role_id == 2) {
            $smstudenuser = SmStudent::where('user_id', $user->id)->first();
            $smstudents = StudentRecord::where('student_id', $smstudenuser->id)->get();

            $lessonIds = SmLesson::pluck('id');
            $topicsmark = SmLessonTopicDetail::pluck('id');

            $userstudents = SmStudentMarkRegister::whereIn('lesson_id', $lessonIds)
                ->whereIn('topic_id', $topicsmark)
                ->where('student_id', $smstudenuser->id)
                ->with('student')->get();
        } elseif ($user->role_id == 1 || $user->role_id == 5) {
            $smstudents = SmStudent::all();

            $smstudenuser = SmStudent::get();
        } elseif ($user->role_id == 4) {
            $smstudenuser = SmStudent::get();
            if ($smstaff) {
                $assign_subjects = SmAssignSubject::where('teacher_id', $smstaff->id)->groupby('class_id')->get();
                // if ($assign_subjects->isEmpty()) {
                //     Toastr::error('No class assignments found for the current user.', 'Error');
                //     return redirect()->back();
                // }
            }
        }
        else {
            $smstudenuser = SmStudent::get();
            if ($smstaff) {
                $assign_subjects = SmAssignSubject::where('teacher_id', $smstaff->id)->groupby('class_id')->get();
               
            }
        }

        $lessons = SmLesson::with('topics')
            ->where('subject_id', $subjectId)
            ->where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->get();

        $lessonCount = $lessons->count();
        $studentIds = StudentRecord::where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->pluck('student_id');

        $students = SmStudent::whereIn('id', $studentIds)->get();
        $topicIds = SmLessonTopic::where('subject_id', $subjectId)->pluck('id');
        $topics = SmLessonTopicDetail::whereIn('topic_id', $topicIds)->get();
        $topicId = $topics->pluck('id')->flatten();


        $subtopics = LessonPlanTopic::whereIn('topic_id', $topicId)
            ->select('topic_id', DB::raw('SUM(max_marks) as total_max_marks'))
            ->with('topicName')
            ->groupBy('topic_id')
            ->get();

        $lessonId = $topics->pluck('lesson_id')->unique()->toArray();
        $lesswoncall = LessonPlanTopic::whereIn('lesson_id', $lessonId)
            ->groupBy('lesson_id')
            ->select('lesson_id', DB::raw('SUM(max_marks) as total_max_marks'))
            ->get();

        $call = LessonPlanTopic::whereIn('lesson_id', $lessonId)->get();
        $Id = $call->pluck('topic_id')->unique()->toArray();

        $ics = SmLessonTopicDetail::whereNotIn('id', $Id)
            ->select('id', DB::raw('SUM(max_marks) as total_max_marks'))
            ->groupBy('id')
            ->get()
            ->keyBy('id');

        $cgpa = SmLessonTopicDetail::whereIn('lesson_id', $lessonId)
            ->select('lesson_id', DB::raw('SUM(cgpa) as cgpa_mark'))
            ->groupBy('lesson_id')
            ->get();


        $enable = SmLessonTopicDetail::where('is_mark_enabled', 1)->exists();
        $OverallPercentage = $cgpa->sum('cgpa_mark');
        $totalCgpa = $topics->sum('cgpa');


        $studentid_marks = SmStudent::where('user_id', $user->id)->pluck('id');
        $studentmarks = SmStudentMarkRegister::whereIn('student_id', $studentid_marks)->get();
        $isLocked = $studentmarks->contains('is_student_marks_locked', 2);

        if ($user->role_id == 2) {
            $class_id = $smstudents->pluck('class_id');
            $sectionId = $smstudents->pluck('section_id');

            $assign_subjects = SmAssignSubject::whereIn('class_id', $class_id)->whereIn('section_id', $sectionId)->get();
            $subjectIds = SmAssignSubject::whereIn('class_id', $class_id)->pluck('subject_id');
            $subjects = SmSubject::whereIn('id', $subjectIds)->get();

            $lessons = SmLesson::whereIn('subject_id', $subjectIds)
                ->whereIn('class_id', $class_id)
                ->with('topics')->get();

            $lessonCount = $lessons->count();
            $topicIds = SmLessonTopic::whereIn('subject_id', $subjectIds)->pluck('id');
            $topics = SmLessonTopicDetail::whereIn('topic_id', $topicIds)->get();

            $topicId = $topics->pluck('id')->flatten();
            $subtopics = LessonPlanTopic::whereIn('topic_id', $topicId)
                ->select('topic_id', DB::raw('SUM(max_marks) as total_max_marks'))
                ->with('topicName')
                ->groupBy('topic_id')
                ->get();

            $topic_id = SmLessonTopic::where('subject_id', $request->subject_id)->pluck('id');
            $topicscount = SmLessonTopicDetail::whereIn('topic_id', $topic_id)->count();
            $subtopicscount = LessonPlanTopic::where('subject_id', $request->subject_id)->count();

            $lessonId = $topics->pluck('lesson_id')->unique()->toArray();
            $idcall = LessonPlanTopic::whereIn('lesson_id', $lessonId)->get();
            $Id = $idcall->pluck('topic_id')->unique()->toArray();

            $cgpa = SmLessonTopicDetail::whereIn('lesson_id', $lessonId)
                ->select('lesson_id', DB::raw('SUM(cgpa) as cgpa_mark'))
                ->groupBy('lesson_id')
                ->get();

            $studentIds = StudentRecord::whereIn('class_id', $class_id)
                ->whereIn('section_id', $sectionId)
                ->pluck('student_id');

            $students = SmStudent::whereIn('id', $studentIds)->get();
            $OverallPercentage = $cgpa->sum('cgpa_mark');

            $topicsmark = SmLessonTopicDetail::pluck('id');
            $studendcount = SmStudentMark::count();
            $topicsandsubtopicscount = $subtopicscount + $topicscount;

            $progresscount = SmStudentMarkRegister::whereIn('topic_id', $topicsmark)
                ->where('student_id', $smstudenuser->id)
                ->groupBy('student_id')
                ->count();

            $subtopicsid = LessonPlanTopic::pluck('id');
            $subtopicsprogess = SmStudentMarkRegister::whereIn('sub_topic_id', $subtopicsid)
                ->where('student_id', $smstudenuser->id)
                ->groupBy('student_id')
                ->count();

            $progresscounttopicsandsubtopics = $progresscount + $subtopicsprogess;

            if ($topicsandsubtopicscount > 0) {
                $progress = ($progresscounttopicsandsubtopics / $topicsandsubtopicscount) * 100;
            }
        }


        $lessonidcall = LessonPlanTopic::whereIn('lesson_id', $lessonId)
            ->groupBy('lesson_id')
            ->select('lesson_id', DB::raw('SUM(max_marks) as total_max_marks'))
            ->get();

        $max_marks = SmLessonTopicDetail::whereNotIn('id', $Id)
            ->select('id', DB::raw('SUM(max_marks) as total_max_marks'))
            ->groupBy('id')
            ->get()
            ->keyBy('id');

        $studentIds = SmStudent::pluck('id');
        $lessonIds = SmLesson::pluck('id');
        $subtopicsid = LessonPlanTopic::pluck('id');
        $topicsmark = SmLessonTopicDetail::pluck('id');

        $studentmarkdata = SmStudentMarkRegister::whereIn('lesson_id', $lessonIds)
            ->whereIn('topic_id', $topicsmark)
            ->whereIn('student_id', $studentIds)
            ->with('student')
            ->get();


        return view('programs.mark', compact(
            'studentmarkdata',
            'smstudenuser',
            'userstudents',
            'cgpa',
            'lessonidcall',
            'lessonCount',
            'OverallPercentage',
            'isLocked',
            'classes',
            'user',
            'assign_subjects',
            'subject',
            'lessons',
            'smstudents',
            'studentmarks',
            'smstaff',
            'students',
            'lessons',
            'subtopicscount',
            'topicscount',
            'progress',
            'ics',
            'max_marks'
        ));
    }


    public function getSubjects(Request $request)
    {
        $user = Auth::user();
        $smStudentUser = SmStudent::where('user_id', $user->id)->first();

        if (!$smStudentUser) {
            return response()->json(['error' => 'Student not found'], 404);
        }


        $classId = $request->input('class_id');
        $sectionId = $request->input('section_id');

        if (!$classId || !$sectionId) {
            return response()->json(['error' => 'Class ID and Section ID are required'], 400);
        }


        $subjectIds = SmAssignSubject::where('class_id', $classId)->pluck('subject_id');


        $subjects = SmSubject::with(['lessons' => function ($query) use ($classId) {
            $query->where('class_id', $classId)->with('topics.subtopics');
        }])->whereIn('id', $subjectIds)->get()->map(function ($subject) use ($smStudentUser, $classId) {

            $studentRecord = StudentRecord::where('student_id', $smStudentUser->id)
                ->where('class_id', $classId)
                ->first();

            $studentMarks = SmStudentMarkRegister::where('student_id', $smStudentUser->id)
                ->whereIn('topic_id', $subject->lessons->flatMap->topics->pluck('id'))
                ->whereIn('lesson_id', $subject->lessons->pluck('id'))
                ->get();

            $studentMarktopics_id = $studentMarks->groupBy('topic_id')->count();

            $studentMarkSubtopics_id = $studentMarks->pluck('sub_topic_id')->groupBy('sub_topic_id')->count();

            $studentMarksprograss_count = $studentMarktopics_id + $studentMarkSubtopics_id;
            $subject->lesson_count = $subject->lessons->count();


            $subject->topics_count = 0;
            $subject->subtopics_count = 0;


            if ($subject->lessons) {
                $subject->topics_count = $subject->lessons->flatMap->topics->count();
                $subject->subtopics_count = $subject->lessons->flatMap->topics->flatMap->subtopics->count();
            }

            $prograsscount = $subject->topics_count + $subject->subtopics_count;


            // $prograss = ($studentMarksprograss_count > 0 && $prograsscount > 0) 
            //     ? ($prograsscount / $studentMarksprograss_count) * 100 
            //     : 0;

            $progress = ($studentMarksprograss_count > 0 && $prograsscount > 0 && ($prograsscount / $studentMarksprograss_count) * 100 >= 100)
                ? 100
                : 0;

            if ($studentRecord) {
                $subject->student_record = $studentRecord;
            }
            if ($studentMarks) {
                $subject->student_Mark = $studentMarks;
            }
            $subject->progress = $progress;

            return $subject;
        });

        return response()->json([
            'subjects' => $subjects,
            'user_id' => $user->id,
        ]);
    }


    public function ajaxClassSection(Request $request)
    {
        $classsection=SmClassSection::where('class_id', $request->id)->pluck('section_id');
        // $sectionIds = SmAssignSubject::where('class_id', $request->id)->pluck('section_id');

        $promote_sections = SmSection::whereIn('id', $classsection)->get();

        return response()->json([$promote_sections]);
    }

    public function ajaxClassteacherSection(Request $request)
    {
        $smstaff = SmStaff::where('user_id', Auth::user()->id)->first();
        $sectionIds = SmAssignSubject::where('teacher_id', $smstaff->id)->pluck('section_id');
        $promote_sections = SmSection::whereIn('id', $sectionIds)->get();
        return response()->json([$promote_sections]);
    }

    public function ajaxClassteacherSubject(Request $request)
    {
        $smstaff = SmStaff::where('user_id', Auth::user()->id)->first();
        $subjectIds = SmAssignSubject::where('teacher_id', $smstaff->id)->pluck('subject_id');
        $promote_sections = SmSubject::whereIn('id', $subjectIds)->get();
        return response()->json([$promote_sections]);
    }

    public function ajaxSectionSubject(Request $request)
    {
        $sectionIds = SmAssignSubject::where('section_id', $request->id)->pluck('subject_id');

        $promote_sections = SmSubject::whereIn('id', $sectionIds)->get();

        return response()->json([$promote_sections]);
    }

    public function assignSubjectFind(Request $request)
    {
        try {
            $input = $request->all();
            $user = Auth::user();
            $request->validate([
                'class' => 'required|exists:sm_classes,id',
                'section_id' => 'required|exists:sm_sections,id',
                'subject_id' => 'required|exists:sm_subjects,id',
            ]);
            $smstaff = SmStaff::where('user_id', Auth::user()->id)->first();
            $assign_subjects = SmAssignSubject::where('class_id', $request->class)->where('section_id', $request->section_id)->where('subject_id', $request->subject_id)->with('subject')->get();
            $subjects = SmSubject::where('id', $request->subject_id)->get();
            $classes = SmClass::where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', $user->school_id)->get();
            $class_id = $request->class;
            $section_id = $request->section_id;
            $lessons = SmLesson::where('subject_id', $request->subject_id)->where('class_id', $class_id)->where('section_id', $section_id)->with('topics')->get();
            $lessonCount = $lessons->count();
            $studentIds = StudentRecord::where('class_id', $class_id)->where('section_id', $section_id)->pluck('student_id');
            $students = SmStudent::whereIn('id', $studentIds)->get();
            $topicIds = SmLessonTopic::where('subject_id', $request->subject_id)->pluck('id');
            $topics = SmLessonTopicDetail::whereIn('topic_id', $topicIds)->get();
            $count = $topics->count();
            $topicId = $topics->pluck('id')->flatten();
            $subtopics = LessonPlanTopic::whereIn('topic_id', $topicId)
                ->select('topic_id', DB::raw('SUM(max_marks) as total_max_marks'))
                ->with('topicName')
                ->groupBy('topic_id')
                ->get();

            $lessonId = $topics->pluck('lesson_id')->unique()->toArray();
            $lessonidcall = LessonPlanTopic::whereIn('lesson_id', $lessonId)
                ->groupBy('lesson_id')
                ->select('lesson_id', DB::raw('SUM(max_marks) as total_max_marks'))
                ->get();
            $idcall = LessonPlanTopic::whereIn('lesson_id', $lessonId)->get();
            $Id = $idcall->pluck('topic_id')->unique()->toArray();
            $max_marks = SmLessonTopicDetail::whereNotIn('id', $Id)
                ->select('id', DB::raw('SUM(max_marks) as total_max_marks'))
                ->groupBy('id')
                ->get()
                ->keyBy('id');
            $subtopicscount_id = LessonPlanTopic::whereIn('topic_id', $topicId)->get();
            $topicscount_id = SmLessonTopicDetail::whereIn('lesson_id', $lessonId)->get();
            $grandmark = $max_marks;
            $cgpa = SmLessonTopicDetail::whereIn('lesson_id', $lessonId)
                ->select('lesson_id', DB::raw('SUM(cgpa) as cgpa_mark'))
                ->groupBy('lesson_id')
                ->get();
            $enable = SmLessonTopicDetail::where('is_mark_enabled', 1)->exists();
            $OverallPercentage = $cgpa->sum('cgpa_mark');
            $count_topic = $subtopics;
            $averageCgpa = 0;
            $totalCgpa = $topics->sum('cgpa');
            $studentIds = StudentRecord::where('class_id', $request->class)->where('section_id', $request->section_id)->pluck('student_id');
            $lessonIds = SmLesson::pluck('id');
            $topicsmark = SmLessonTopicDetail::pluck('id');
            $studentmarkdata = SmStudentMarkRegister::whereIn('lesson_id', $lessonIds)
                ->whereIn('topic_id', $topicsmark)->get();
            $topicIds = $studentmarkdata->pluck('topic_id')->unique();
            $avgMarks = SmLessonTopicDetail::whereIn('id', $topicIds)->pluck('avg_marks');
            $averageMark = $avgMarks->avg();
            $subtopicIds = $studentmarkdata->pluck('sub_topic_id')->unique();
            $subtopicavgMarks = LessonPlanTopic::whereIn('id', $subtopicIds)->pluck('avg_marks');
            $subtopicaverageMark = $subtopicavgMarks->avg();
            $lesson_count = SmLesson::where('subject_id', $request->subject_id)->where('class_id', $class_id)->where('section_id', $section_id)->groupBy('subject_id')->count();
            $topic_id = SmLessonTopic::where('subject_id', $request->subject_id)->pluck('id');
            $topicscount = SmLessonTopicDetail::whereIn('topic_id', $topic_id)->count();
            $subtopicscount = LessonPlanTopic::where('subject_id', $request->subject_id)->count();
            $studendcount = SmStudentMark::where('class_id', $request->class)
                ->where('section_id', $request->section_id)
                ->where('subject_id', $request->subject_id)
                ->get();
            $studentGroup = $studendcount->groupBy('student_id')->count();
            $classcount = StudentRecord::where('class_id', $request->class)->where('section_id', $request->section_id)->pluck('student_id')->count();

            if ($classcount > 0) {
                $progresscount = intval(($studentGroup / $classcount) * 100);
                $progresscount = min($progresscount, 100);
            } else {
                $progresscount = 0;
            }

            $topicsMarks = SmLessonTopicDetail::whereIn('lesson_id', $lessonId)->get();
            $selectedFields = $topicsMarks->filter(function ($topic) {
                return $topic->is_mark_enabled == 1;
            })->map(function ($topic) {
                return [
                    'id' => $topic->id,
                    'is_mark_enabled' => true,
                ];
            });

            return view('programs.mark', compact('subtopicaverageMark', 'averageMark', 'selectedFields', 'topicsmark', 'studentGroup', 'topicscount_id', 'subtopicscount_id', 'lesson_count', 'progresscount', 'studendcount', 'subtopicscount', 'topicscount', 'subtopicscount', 'studentmarkdata', 'enable', 'totalCgpa', 'OverallPercentage', 'cgpa', 'max_marks', 'lessonidcall', 'grandmark', 'count_topic', 'subtopics', 'averageCgpa', 'count', 'lessonCount', 'topics', 'students', 'lessons', 'user', 'classes', 'assign_subjects', 'subjects', 'class_id', 'section_id'));
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function assignSubjectTeacherFind(Request $request)
    {

        $input = $request->all();
        $user = Auth::user();
        $request->validate([
            'class' => 'required|exists:sm_classes,id',
            'section_id' => 'required|exists:sm_sections,id',
            'subject_id' => 'required|exists:sm_subjects,id',
        ]);
        $smstaff = SmStaff::where('user_id', Auth::user()->id)->first();
        $assign_teacher_subjects = SmAssignSubject::where('class_id', $request->class)->where('section_id', $request->section_id)->where('subject_id', $request->subject_id)->with('subject')->get();
        $subjects = SmSubject::where('id', $request->subject_id)->get();
        $classes = SmClass::where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', $user->school_id)->get();
        $class_id = $request->class;
        $section_id = $request->section_id;
        $lessons = SmLesson::where('subject_id', $request->subject_id)->where('class_id', $class_id)->where('section_id', $section_id)->with('topics')->get();
        $lessonCount = $lessons->count();
        $studentIds = StudentRecord::where('class_id', $class_id)->where('section_id', $section_id)->pluck('student_id');
        $students = SmStudent::whereIn('id', $studentIds)->get();
        $topicIds = SmLessonTopic::where('subject_id', $request->subject_id)->pluck('id');
        $topics = SmLessonTopicDetail::whereIn('topic_id', $topicIds)->get();
        $count = $topics->count();
        $topicId = $topics->pluck('id')->flatten();
        $subtopics = LessonPlanTopic::whereIn('topic_id', $topicId)
            ->select('topic_id', DB::raw('SUM(max_marks) as total_max_marks'))
            ->with('topicName')
            ->groupBy('topic_id')
            ->get();
        $lessonId = $topics->pluck('lesson_id')->unique()->toArray();
        $lessonidcall = LessonPlanTopic::whereIn('lesson_id', $lessonId)
            ->groupBy('lesson_id')
            ->select('lesson_id', DB::raw('SUM(max_marks) as total_max_marks'))
            ->get();
        $idcall = LessonPlanTopic::whereIn('lesson_id', $lessonId)->get();
        $Id = $idcall->pluck('topic_id')->unique()->toArray();
        $max_marks = SmLessonTopicDetail::whereNotIn('id', $Id)
            ->select('id', DB::raw('SUM(max_marks) as total_max_marks'))
            ->groupBy('id')
            ->get()
            ->keyBy('id');
        $grandmark = $max_marks;
        $cgpa = SmLessonTopicDetail::whereIn('lesson_id', $lessonId)
            ->select('lesson_id', DB::raw('SUM(cgpa) as cgpa_mark'))
            ->groupBy('lesson_id')
            ->get();
        $enable = SmLessonTopicDetail::where('is_mark_enabled', 1)->exists();
        $OverallPercentage = $cgpa->sum('cgpa_mark');
        $count_topic = $subtopics;
        $averageCgpa = 0;
        $totalCgpa = $topics->sum('cgpa');
        $studentIds = SmStudent::pluck('id');
        $lessonIds = SmLesson::pluck('id');

        $topicsmark = SmLessonTopicDetail::pluck('id');

        $studentmarkdata = SmStudentMarkRegister::whereIn('lesson_id', $lessonIds)
            ->whereIn('topic_id', $topicsmark)->get();
        $topicIds = $studentmarkdata->pluck('topic_id')->unique();
        $avgMarks = SmLessonTopicDetail::whereIn('id', $topicIds)->pluck('avg_marks');
        $averageMark = $avgMarks->avg();
        $subtopicIds = $studentmarkdata->pluck('sub_topic_id')->unique();
        $subtopicavgMarks = LessonPlanTopic::whereIn('id', $subtopicIds)->pluck('avg_marks');
        $subtopicaverageMark = $subtopicavgMarks->avg();
        $isLocked = $assign_teacher_subjects->contains('is_marks_locked', 2);
        $lesson_count = SmLesson::where('subject_id', $request->subject_id)->where('class_id', $class_id)->where('section_id', $section_id)->groupBy('subject_id')->count();
        $topic_id = SmLessonTopic::where('subject_id', $request->subject_id)->pluck('id');
        $topicscount = SmLessonTopicDetail::whereIn('topic_id', $topic_id)->count();
        $subtopicscount = LessonPlanTopic::where('subject_id', $request->subject_id)->count();
        $studendcount = SmStudentMark::where('class_id', $request->class)
            ->where('section_id', $request->section_id)
            ->where('subject_id', $request->subject_id)
            ->get();
        $studentGroup = $studendcount->groupBy('student_id')->count();
        $classcount = StudentRecord::where('class_id', $request->class)->where('section_id', $request->section_id)->pluck('student_id')->count();

        if ($classcount > 0) {
            $progresscount = intval(($studentGroup / $classcount) * 100);
            $progresscount = min($progresscount, 100);
        } else {
            $progresscount = 0;
        }

        $topicsMarks = SmLessonTopicDetail::whereIn('lesson_id', $lessonId)->get();


        $selectedFields = $topicsMarks->filter(function ($topic) {
            return $topic->is_mark_enabled == 1;
        })->map(function ($topic) {
            return [
                'id' => $topic->id,
                'is_mark_enabled' => true,
            ];
        });

        return view('programs.mark', compact('subtopicaverageMark', 'averageMark', 'selectedFields', 'topicsMarks', 'studentGroup', 'lesson_count', 'isLocked', 'progresscount', 'studendcount', 'subtopicscount', 'topicscount', 'subtopicscount', 'studentmarkdata', 'enable', 'totalCgpa', 'OverallPercentage', 'cgpa', 'max_marks', 'lessonidcall', 'grandmark', 'count_topic', 'subtopics', 'averageCgpa', 'count', 'lessonCount', 'topics', 'students', 'lessons', 'user', 'classes', 'assign_teacher_subjects', 'subjects', 'class_id', 'section_id'));
    }


    public function lockRequest(Request $request, $id, $action)
    {
        try {
            $assignSubject = SmAssignSubject::find($id);
            if (!$assignSubject) {
                return response()->json(['message' => 'Subject not found'], 404);
            }
            if (!$request->has('notes')) {
                return response()->json(['message' => 'Notes are required'], 400);
            }
            switch ($action) {
                case 'lock request':
                    $assignSubject->is_marks_locked = 3;
                    break;
                case 'unlock request':
                    $assignSubject->is_marks_locked = 4;
                    break;
                default:
                    return response()->json(['message' => 'Invalid action'], 400);
            }
            $assignSubject->marks_notes = $request->input('notes');
            $assignSubject->save();
            $roles = [1, 5]; 
            foreach ($roles as $role) {
                sendNotification("Mark Unlock Request Received", '/program/my-programs?teacher=' . $assignSubject->teacher_id, $role, $role);
            }
            $job = (new MarkJob($assignSubject, $action))->delay(Carbon::now()->addSeconds(10));
            dispatch($job);


            return response()->json(['success' => true, 'message' => 'Request Send successfully.']);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function mystudent()
    {
        return view('programs.my_students');
    }

    public function saveMarks(Request $request)
    {

        $request->validate([
            'marks' => 'required',
            'assign_subject_id' => 'required|integer',
            'total_marks' => 'required|array',
        ]);

        $user = Auth::user();

        DB::transaction(function () use ($request, $user) {
            $data = json_decode($request->input('marks'), true);
            $totalMarks = $request->input('total_marks');
            foreach ($data as $markData) {

                if (empty($markData['mark']) || $markData['mark'] == 0) {
                    continue;
                }

                $studentRecord = StudentRecord::where('student_id', $markData['student_id'])->first();
                if (!$studentRecord) {
                    throw new \Exception("Student record not found for student_id: " . $markData['student_id']);
                }

                $classId = $studentRecord->class_id;
                $sectionId = $studentRecord->section_id;
                $subjectId = $request->input('assign_subject_id');
                $subject = SmAssignSubject::where('id', $subjectId)->value('subject_id');

                $subTopicIds = is_array($markData['sub_topic_id']) ? $markData['sub_topic_id'] : [$markData['sub_topic_id']];

                foreach ($subTopicIds as $subTopicId) {
                    if ($user->role_id == 1) {
                        $smstudent = SmStudentMark::where([
                            ['topic_id', '=', $markData['topic_id']],
                            ['lesson_id', '=', $markData['lesson_id']],
                            ['student_id', '=', $markData['student_id']],
                            ['class_id', '=', $classId],
                            ['section_id', '=', $sectionId],
                            ['sub_topic_id', '=', $subTopicId]
                        ])->first();

                        if ($smstudent) {
                            $smstudent->update(['subject_id' => $subject]);
                        } else {
                            $smstudent = SmStudentMark::create([
                                'topic_id' => $markData['topic_id'],
                                'lesson_id' => $markData['lesson_id'],
                                'student_id' => $markData['student_id'],
                                'sub_topic_id' => $subTopicId,
                                'class_id' => $classId,
                                'section_id' => $sectionId,
                                'subject_id' => $subject,
                            ]);
                        }

                        $this->updateOrCreateStudentMarkRegister($markData, $smstudent->id, $subject);
                    } elseif ($user->role_id == 4) {
                        $studentMark = SmStudentMark::where([
                            ['topic_id', '=', $markData['topic_id']],
                            ['lesson_id', '=', $markData['lesson_id']],
                            ['student_id', '=', $markData['student_id']],
                            ['class_id', '=', $classId],
                            ['section_id', '=', $sectionId],
                            ['sub_topic_id', '=', $subTopicId]
                        ])->first();

                        if (empty($studentMark)) {
                            $studentMark = SmStudentMark::create([
                                'topic_id' => $markData['topic_id'],
                                'lesson_id' => $markData['lesson_id'],
                                'student_id' => $markData['student_id'],
                                'sub_topic_id' => $subTopicId,
                                'class_id' => $classId,
                                'section_id' => $sectionId,
                                'subject_id' => $subject,
                            ]);
                        } else {
                            $studentMark->update([
                                'sub_topic_id' => $subTopicId,
                                'subject_id' => $subject,
                            ]);
                        }

                        SmStudentMarkRegister::updateOrCreate(
                            [
                                'student_mark_id' => $studentMark->id,
                                'student_id' => $markData['student_id'],
                                'topic_id' => $markData['topic_id'],
                                'lesson_id' => $markData['lesson_id'],
                                'subject_id' => $subject,
                                'sub_topic_id' => $markData['sub_topic_id'] ?? 0,
                            ],
                            [
                                'mark_value' => $markData['mark'],
                                'total' => $markData['total'] ?? 0,
                                'average' => $markData['average'] ?? 0,
                                'percentage' => $markData['percentage'] ?? 0,
                                'grand_total' => $markData['grandtotal'] ?? 0,
                                'grand_percentage' => $markData['grandpercentage'] ?? 0,
                                'overall_percpercentage' => $markData['overallPercentage'] ?? 0,
                            ]
                        );
                    }
                    else{
                        $studentMark = SmStudentMark::where([
                            ['topic_id', '=', $markData['topic_id']],
                            ['lesson_id', '=', $markData['lesson_id']],
                            ['student_id', '=', $markData['student_id']],
                            ['class_id', '=', $classId],
                            ['section_id', '=', $sectionId],
                            ['sub_topic_id', '=', $subTopicId]
                        ])->first();

                        if (empty($studentMark)) {
                            $studentMark = SmStudentMark::create([
                                'topic_id' => $markData['topic_id'],
                                'lesson_id' => $markData['lesson_id'],
                                'student_id' => $markData['student_id'],
                                'sub_topic_id' => $subTopicId,
                                'class_id' => $classId,
                                'section_id' => $sectionId,
                                'subject_id' => $subject,
                            ]);
                        } else {
                            $studentMark->update([
                                'sub_topic_id' => $subTopicId,
                                'subject_id' => $subject,
                            ]);
                        }

                        SmStudentMarkRegister::updateOrCreate(
                            [
                                'student_mark_id' => $studentMark->id,
                                'student_id' => $markData['student_id'],
                                'topic_id' => $markData['topic_id'],
                                'lesson_id' => $markData['lesson_id'],
                                'subject_id' => $subject,
                                'sub_topic_id' => $markData['sub_topic_id'] ?? 0,
                            ],
                            [
                                'mark_value' => $markData['mark'],
                                'total' => $markData['total'] ?? 0,
                                'average' => $markData['average'] ?? 0,
                                'percentage' => $markData['percentage'] ?? 0,
                                'grand_total' => $markData['grandtotal'] ?? 0,
                                'grand_percentage' => $markData['grandpercentage'] ?? 0,
                                'overall_percpercentage' => $markData['overallPercentage'] ?? 0,
                            ]
                        );
                    }
                }

                $studentId = $markData['student_id'];
                $totalMarkValue = $totalMarks[$studentId] ?? 0;

                $mark_grade = SmMarksGrade::where([
                    ['percent_from', '<=', (float)$totalMarkValue],
                    ['percent_upto', '>=', (float)$totalMarkValue]
                ])
                    ->where('academic_id', getAcademicId())
                    ->where('school_id', Auth::user()->school_id)
                    ->first();

                $SmResultStore = SmStudentMarkGrade::where([
                    ['subject_id', $subject],
                    ['student_record_id', $studentId]
                ])->first();

                if (!$SmResultStore) {
                    $result_record = new SmStudentMarkGrade();
                    $result_record->subject_id = $subject;
                    $result_record->student_record_id = $studentId;
                    $result_record->is_absent = isset($absent_students) && in_array($studentId, $absent_students) ? 1 : 0;
                    $result_record->total_marks = (float)$totalMarkValue;
                    $result_record->total_gpa_point = $markData['overallPercentage'];
                    $result_record->total_gpa_grade = @$mark_grade->grade_name;
                    $result_record->class_id = $classId;
                    $result_record->section_id = $sectionId;
                    $result_record->created_at = now();
                    $result_record->school_id = Auth::user()->school_id;
                    $result_record->academic_id = getAcademicId();
                    $result_record->save();
                } else {
                    $result_record = SmStudentMarkGrade::find($SmResultStore->id);
                    $result_record->total_marks = (float)$totalMarkValue;
                    $result_record->total_gpa_point = $markData['overallPercentage'];
                    $result_record->total_gpa_grade = @$mark_grade->grade_name;
                    $result_record->class_id = $classId;
                    $result_record->section_id = $sectionId;
                    $result_record->student_record_id = $studentId;
                    $result_record->created_at = now();
                    $result_record->is_absent = isset($absent_students) && in_array($studentId, $absent_students) ? 1 : 0;
                    $result_record->teacher_remarks = gv($studentId, 'teacher_remarks');
                    $result_record->save();
                }
            }
        });

        return response()->json(['success' => true, 'message' => 'Marks saved/updated successfully']);
    }


    private function updateOrCreateStudentMarkRegister(array $markData, int $studentMarkId,  int $subject)
    {
        SmStudentMarkRegister::updateOrCreate(
            [
                'student_mark_id' => $studentMarkId,
            ],
            [
                'mark_value' => $markData['mark'],
                'total' => $markData['total'] ?? 0,
                'average' => $markData['average'] ?? 0,
                'percentage' => $markData['percentage'] ?? 0,
                'grand_total' => $markData['grandtotal'] ?? 0,
                'grand_percentage' => $markData['grandpercentage'] ?? 0,
                'overall_percpercentage' => $markData['overallPercentage'] ?? 0,
                'topic_id' => $markData['topic_id'] ?? 0,
                'lesson_id' => $markData['lesson_id'] ?? 0,
                'sub_topic_id' => $markData['sub_topic_id'] ?? 0,
                'student_id' => $markData['student_id'],
                'subject_id' => $subject,
            ]
        );
    }

    public function updateStatus($id, $action)
    {
        try {
            $assignSubject = SmAssignSubject::find($id);
            if (!$assignSubject) {
                return response()->json(['message' => 'Subject not found'], 404);
            }


            switch ($action) {
                case 'lock':
                    $assignSubject->is_marks_locked = 1;
                    $notificationMessage = "Mark has been locked.";
                    $notificationUrl = '/program/my-programs?teacher=' . $assignSubject->teacher->user_id;
                    break;
                case 'unlock':
                    $assignSubject->is_marks_locked = 2;
                    $notificationMessage = "Mark has been unlocked.";
                    $notificationUrl = '/program/my-programs?teacher=' . $assignSubject->teacher->user_id;
                    break;
                case 'reject':
                    $assignSubject->is_marks_locked = 5;
                    $notificationMessage = "Mark Unlock Request Rejected.";
                    $notificationUrl = '/program/my-programs?teacher=' . $assignSubject->teacher->user_id;
                    break;
                default:
                    return response()->json(['message' => 'Invalid action'], 400);
            }
            $assignSubject->save();
            sendNotification($notificationMessage, $notificationUrl, $assignSubject->teacher->user_id, 4);
            $job = (new MarkJob($assignSubject, $action))->delay(Carbon::now()->addSeconds(10));
            dispatch($job);
            return response()->json(['message' => 'Status updated successfully']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function updateMarkLock(Request $request)
    {
        $request->validate([
            'student_id' => 'required|integer',
            'topic_id' => 'required|integer',
            'lock_status' => 'required|integer',
        ]);

        $user = Auth::user();

        $smstudent = SmStudentMark::updateOrCreate(
            [
                'user_id' => $user->id,
                'topic_id' => $request->topic_id,
                'student_id' => $request->student_id,
            ],
            [
                'is_student_marks_locked' => $request->lock_status == 0 ? 1 : 2
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Mark lock status updated successfully',
        ]);
    }

    public function downloadPDF(Request $request)
    {

        $studentMarks = SmStudentMarkRegister::where('student_id', $request->student_id)
            ->with('student')
            ->get();
        if ($studentMarks->isEmpty()) {
            return response()->json(['error' => 'No marks found for the student.'], 404);
        }

        $studentId = $request->student_id;
        $classIds = SmStudentMark::where('student_id', $studentId)->pluck('class_id')->unique();


        $assignSubjects = SmAssignSubject::whereIn('class_id', $classIds)->get();


        $subjects = [];
        $grandTotalMarks = 0;
        $grandTotalPercentagePoint = 0;

        foreach ($assignSubjects as $assignSubject) {
            $marks = SmStudentMarkRegister::where('subject_id', $assignSubject->subject_id)
                ->where('student_id', $studentId)
                ->distinct()
                ->get();


            $overallPercentage = SmStudentMarkRegister::where('subject_id', $assignSubject->subject_id)
                ->first();

            $lessonIds = StudentRecord::where('student_id', $studentId)->pluck('student_id')->unique();

            $totalMark = SmStudentMarkGrade::where('subject_id', $assignSubject->subject_id)
                ->where('student_record_id', $studentId)
                ->sum('total_marks');

            $totalPercentagePoint = SmStudentMarkGrade::where('subject_id', $assignSubject->subject_id)
                ->where('student_record_id', $studentId)
                ->sum('total_gpa_point');


            $grandTotalMarks += $totalMark;
            $grandTotalPercentagePoint += $totalPercentagePoint;

            $lessonTotals = [];
            foreach ($lessonIds as $lessonId) {
                $grandTotal = SmStudentMarkGrade::where('student_record_id', $lessonId)
                    ->where('subject_id', $assignSubject->subject_id)
                    ->first();

                $lessonTotals[$lessonId] = [
                    'total_marks' => $grandTotal->total_marks ?? 0,
                    'total_gpa_grade' => $grandTotal->total_gpa_grade ?? 0,
                ];
            }
            $gradestudents = SmStudentMarkGrade::where('subject_id', $assignSubject->subject_id)
            ->where('student_record_id', $studentId)
            ->get();


        $result = '';

        foreach ($gradestudents as $gradestudent) {
            $topicPass = SmStudentMarkRegister::whereNotNull('mark_value')
                ->whereIn('topic_id', SmLessonTopicDetail::whereNotNull('avg_marks')->pluck('id'))
                ->where('sub_topic_id', 0)
                ->where('student_id', $gradestudent->student_record_id)
                ->where('subject_id', $gradestudent->subject_id)
                ->get()
                ->every(fn($topic) => $topic->mark_value >= SmLessonTopicDetail::where('id', $topic->topic_id)->value('avg_marks'));

            $subTopicPass = SmStudentMarkRegister::whereNotNull('mark_value')
                ->whereIn('sub_topic_id', LessonPlanTopic::whereNotNull('avg_marks')->pluck('id'))
                ->where('student_id', $gradestudent->student_record_id)
                ->where('subject_id', $gradestudent->subject_id)
                ->get()
                ->every(fn($subTopic) => $subTopic->mark_value >= LessonPlanTopic::where('id', $subTopic->sub_topic_id)->value('avg_marks'));

            if ($topicPass && $subTopicPass) {
                $result = 'Pass';
            }
            else{
                $result = 'fail';
            }
        }
            $subjects[$assignSubject->subject_id] = [
                'subject' => $assignSubject->subject,
                'students' => $marks->pluck('student_id')->unique(),
                'lesson_count' => $lessonIds,
                'lesson_totals' => $lessonTotals,
                'overall_percentage' => $overallPercentage->overall_percentage ?? 0,
                'totalMark' => $totalMark ?? 0,
                'total_percentage_point' => $totalPercentagePoint ?? 0,
                'result' => $result,
            ];
        }

        $student = StudentRecord::where('student_id', $studentId)
            ->with(['academic', 'student', 'section', 'class'])
            ->first();
        $mark_grade = SmMarksGrade::where([
            ['percent_from', '<=', (float)$grandTotalMarks],
            ['percent_upto', '>=', (float)$grandTotalMarks]
        ])
            ->where('academic_id', getAcademicId())
            ->where('school_id', Auth::user()->school_id)
            ->first();

        $result = $this->calculateResult($grandTotalPercentagePoint, count($subjects), $studentId, $assignSubjects);
        $totals = [
            'totalMarks' => number_format($grandTotalMarks, 2),
            'totalGradeValue' => $mark_grade->grade_name ?? 0,
            'totalPercentage' => number_format(($grandTotalMarks / (count($subjects)))),
            'result' => $result
        ];
        $pdf = PDF::loadView('programs.marksheet', [
            'studentMarks' => $studentMarks,
            'student' => $student,
            'subjects' => $subjects,
            'totals' => $totals
        ]);

        $filename = 'students_report.pdf';

        return response()->stream(function () use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    public function downloadPDFs($id)
    {

        $subject = SmStudentMark::where('subject_id', $id)->first();
        if (!$subject) {
            return response()->json(['error' => 'Subject not found.'], 404);
        }
        $students = SmStudentMark::where('subject_id', $id)->pluck('student_id');
        if ($students->isEmpty()) {
            return response()->json(['error' => 'No students found for this subject.'], 404);
        }
        $zipFileName = "mark_lists_{$id}.zip";
        $zipFilePath = public_path($zipFileName);
        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            Log::error("Could not create ZIP file: {$zipFilePath}");
            return response()->json(['error' => 'Could not create ZIP file.'], 500);
        }
        foreach ($students as $studentId) {
            $pdfPath = $this->generatePDF($studentId);
            if ($pdfPath && file_exists($pdfPath) && filesize($pdfPath) > 0) {
                if (!$zip->addFile($pdfPath, basename($pdfPath))) {
                    Log::error("Failed to add {$pdfPath} to the ZIP archive.");
                } else {
                    Log::info("Added {$pdfPath} to the ZIP archive.");
                }
            } else {
                Log::warning("PDF content for student {$studentId} is missing or empty.");
            }
        }
        if (!$zip->close()) {
            Log::error("Could not close ZIP file: {$zipFilePath}");
            return response()->json(['error' => 'Could not close ZIP file.'], 500);
        }
        if (!file_exists($zipFilePath) || filesize($zipFilePath) === 0) {
            Log::error("Created ZIP file is empty or does not exist: {$zipFilePath}");
            return response()->json(['error' => 'Created ZIP file is empty or does not exist.'], 500);
        }
        if (ob_get_length()) {
            ob_end_clean();
        }
        return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
    }

    private function generatePDF($studentId)
    {
        try {
            $classIds = StudentRecord::where('student_id', $studentId)
                ->distinct()
                ->pluck('class_id')
                ->toArray();
            $assignSubjects = SmAssignSubject::whereIn('class_id', $classIds)->get();
            $subjects = [];
            $grandTotalMarks = 0;
            $grandTotalPercentagePoint = 0;
            foreach ($assignSubjects as $assignSubject) {
                $marks = SmStudentMarkRegister::where('subject_id', $assignSubject->subject_id)
                    ->where('student_id', $studentId)
                    ->select('subject_id', 'student_id')
                    ->distinct()
                    ->get();
                $overallPercentage = SmStudentMarkRegister::where('subject_id', $assignSubject->subject_id)
                    ->first();
                $lessonIds = StudentRecord::where('student_id', $studentId)
                    ->pluck('student_id')
                    ->unique();
                $totalMArk = SmStudentMarkGrade::where('subject_id', $assignSubject->subject_id)
                    ->where('student_record_id', $studentId)
                    ->sum('total_marks');
                $total_percentage_point = SmStudentMarkGrade::where('subject_id', $assignSubject->subject_id)
                    ->where('student_record_id', $studentId)
                    ->sum('total_gpa_point');
                $grandTotalMarks += $totalMArk;
                $grandTotalPercentagePoint += $total_percentage_point;
                $lessonTotals = [];
                foreach ($lessonIds as $lessonId) {
                    $grandTotal = SmStudentMarkGrade::where('student_record_id', $lessonId)
                        ->where('subject_id', $assignSubject->subject_id)
                        ->first();
                    $lessonTotals[$lessonId] = [
                        'total_marks' => $grandTotal->total_marks ?? 0,
                        'total_gpa_grade' => $grandTotal->total_gpa_grade ?? 0,
                    ];
                }
                $gradestudents = SmStudentMarkGrade::where('subject_id', $assignSubject->subject_id)
                    ->where('student_record_id', $studentId)
                    ->get();


                $result = '';

                foreach ($gradestudents as $gradestudent) {
                    $topicPass = SmStudentMarkRegister::whereNotNull('mark_value')
                        ->whereIn('topic_id', SmLessonTopicDetail::whereNotNull('avg_marks')->pluck('id'))
                        ->where('sub_topic_id', 0)
                        ->where('student_id', $gradestudent->student_record_id)
                        ->where('subject_id', $gradestudent->subject_id)
                        ->get()
                        ->every(fn($topic) => $topic->mark_value >= SmLessonTopicDetail::where('id', $topic->topic_id)->value('avg_marks'));

                    $subTopicPass = SmStudentMarkRegister::whereNotNull('mark_value')
                        ->whereIn('sub_topic_id', LessonPlanTopic::whereNotNull('avg_marks')->pluck('id'))
                        ->where('student_id', $gradestudent->student_record_id)
                        ->where('subject_id', $gradestudent->subject_id)
                        ->get()
                        ->every(fn($subTopic) => $subTopic->mark_value >= LessonPlanTopic::where('id', $subTopic->sub_topic_id)->value('avg_marks'));

                    if ($topicPass && $subTopicPass) {
                        $result = 'Pass';
                    }
                    else{
                        $result = 'fail';
                    }
                }
                $subjects[$assignSubject->subject_id] = [
                    'subject' => $assignSubject->subject,
                    'students' => $marks->pluck('student_id')->unique(),
                    'lesson_count' => $lessonIds,
                    'lesson_totals' => $lessonTotals,
                    'overall_percentage' => $overallPercentage->overall_percpercentage ?? 0,
                    'totalMArk' => $totalMArk ?? 0,
                    'total_percentage_point' => $total_percentage_point ?? 0,
                    'result' => $result,
                ];
            }
            $student = StudentRecord::where('student_id', $studentId)
                ->with(['academic', 'student', 'section', 'class'])
                ->first();
            $mark_grade = SmMarksGrade::where([
                ['percent_from', '<=', (float)$grandTotalMarks],
                ['percent_upto', '>=', (float)$grandTotalMarks]
            ])
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->first();

            $result = $this->calculateResult($grandTotalPercentagePoint, count($subjects), $studentId, $assignSubjects);
            $totals = [
                'totalMarks' => number_format($grandTotalMarks, 2),
                'totalGradeValue' => $mark_grade->grade_name ?? 0,
                'totalPercentage' => number_format(($grandTotalMarks / (count($subjects)))),
                'result' => $result
            ];
            $pdf = PDF::loadView('programs.marksheet', [
                'student' => $student,
                'subjects' => $subjects,
                'totals' => $totals
            ]);
            $filename = 'students_report_' . $studentId . '.pdf';
            $pdfPath = storage_path('app/temp/' . $filename);
            if (!file_exists(dirname($pdfPath))) {
                mkdir(dirname($pdfPath), 0755, true);
            }
            $pdf->save($pdfPath);
            return $pdfPath;
        } catch (\Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage());
            throw $e;
        }
    }


    public function markReport(Request $request)
    {
        $classes = SmClass::all();
        $students = collect();
        if ($request->has('class_id')) {
            $students = StudentRecord::where('class_id', $request->class_id)
                ->when($request->section_id, function ($query) use ($request) {
                    return $query->where('section_id', $request->section_id);
                })
                ->with('student')
                ->get();
        }
        return view('programs.mark_report', compact('classes', 'students'));
    }

    public function markReportDetails(Request $request)
    {
        $request->validate([
            'class_id' => 'required|array',
            'class_id.*' => 'integer',
            'section_id' => 'nullable|integer',
            'student_id' => 'nullable|integer',
        ]);
        $students = StudentRecord::whereIn('class_id', $request->class_id)
            ->when($request->section_id, function ($query) use ($request) {
                return $query->where('section_id', $request->section_id);
            })
            ->when($request->student_id, function ($query) use ($request) {
                return $query->where('student_id', $request->student_id);
            })
            ->with('student')
            ->groupBy('student_id')
            ->get();

        if ($students->isEmpty()) {
            Log::info('No students found for class_id: ' . implode(',', $request->class_id) . ' and section_id: ' . $request->section_id);
        } else {
            Log::info('Students found: ' . $students->count());
        }
        if ($request->ajax()) {
            return response()->json($students);
        }
    }

    public function exportStudents(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'integer|exists:sm_students,id',
        ]);
        $subject = SmStudentMark::whereIn('student_id', $request->student_ids)->first();
        if (!$subject) {
            return response()->json(['error' => 'Subject not found.'], 404);
        }
        $students = SmStudentMark::whereIn('student_id', $request->student_ids)->groupBy('student_id')->pluck('student_id');
        if ($students->isEmpty()) {
            return response()->json(['error' => 'No students found for this subject.'], 404);
        }
        $zipFileName = "mark_lists_.zip";
        $zipFilePath = public_path($zipFileName);
        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            Log::error("Could not create ZIP file: {$zipFilePath}");
            return response()->json(['error' => 'Could not create ZIP file.'], 500);
        }
        foreach ($students as $studentId) {
            $pdfPath = $this->zipPDF($studentId);
            if ($pdfPath && file_exists($pdfPath) && filesize($pdfPath) > 0) {
                if (!$zip->addFile($pdfPath, basename($pdfPath))) {
                    Log::error("Failed to add {$pdfPath} to the ZIP archive.");
                } else {
                    Log::info("Added {$pdfPath} to the ZIP archive.");
                }
            } else {
                Log::warning("PDF content for student {$studentId} is missing or empty.");
            }
        }

        if (!$zip->close()) {
            Log::error("Could not close ZIP file: {$zipFilePath}");
            return response()->json(['error' => 'Could not close ZIP file.'], 500);
        }
        if (!file_exists($zipFilePath) || filesize($zipFilePath) === 0) {
            Log::error("Created ZIP file is empty or does not exist: {$zipFilePath}");
            return response()->json(['error' => 'Created ZIP file is empty or does not exist.'], 500);
        }
        if (ob_get_length()) {
            ob_end_clean();
        }
        return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
    }

    private function zipPDF($studentId)
    {
        try {
            $classIds = StudentRecord::where('student_id', $studentId)
                ->distinct()
                ->pluck('class_id')
                ->toArray();
            $assignSubjects = SmAssignSubject::whereIn('class_id', $classIds)->get();
            $subjects = [];
            $grandTotalMarks = 0;
            $grandTotalPercentagePoint = 0;
            foreach ($assignSubjects as $assignSubject) {
                $marks = SmStudentMarkRegister::where('subject_id', $assignSubject->subject_id)
                    ->where('student_id', $studentId)
                    ->select('subject_id', 'student_id')
                    ->distinct()
                    ->get();
                $overallPercentage = SmStudentMarkRegister::where('subject_id', $assignSubject->subject_id)
                    ->first();
                $lessonIds = StudentRecord::where('student_id', $studentId)
                    ->pluck('student_id')
                    ->unique();
                $totalMArk = SmStudentMarkGrade::where('subject_id', $assignSubject->subject_id)
                    ->where('student_record_id', $studentId)
                    ->sum('total_marks');
                $total_percentage_point = SmStudentMarkGrade::where('subject_id', $assignSubject->subject_id)
                    ->where('student_record_id', $studentId)
                    ->sum('total_gpa_point');
                $grandTotalMarks += $totalMArk;
                $grandTotalPercentagePoint += $total_percentage_point;
                $lessonTotals = [];
                foreach ($lessonIds as $lessonId) {
                    $grandTotal = SmStudentMarkGrade::where('student_record_id', $lessonId)
                        ->where('subject_id', $assignSubject->subject_id)
                        ->first();
                    $lessonTotals[$lessonId] = [
                        'total_marks' => $grandTotal->total_marks ?? 0,
                        'total_gpa_grade' => $grandTotal->total_gpa_grade ?? 0,
                    ];
                }
                $gradestudents = SmStudentMarkGrade::where('subject_id', $assignSubject->subject_id)
                    ->where('student_record_id', $studentId)
                    ->get();


                $result = '';

                foreach ($gradestudents as $gradestudent) {
                    $topicPass = SmStudentMarkRegister::whereNotNull('mark_value')
                        ->whereIn('topic_id', SmLessonTopicDetail::whereNotNull('avg_marks')->pluck('id'))
                        ->where('sub_topic_id', 0)
                        ->where('student_id', $gradestudent->student_record_id)
                        ->where('subject_id', $gradestudent->subject_id)
                        ->get()
                        ->every(fn($topic) => $topic->mark_value >= SmLessonTopicDetail::where('id', $topic->topic_id)->value('avg_marks'));

                    $subTopicPass = SmStudentMarkRegister::whereNotNull('mark_value')
                        ->whereIn('sub_topic_id', LessonPlanTopic::whereNotNull('avg_marks')->pluck('id'))
                        ->where('student_id', $gradestudent->student_record_id)
                        ->where('subject_id', $gradestudent->subject_id)
                        ->get()
                        ->every(fn($subTopic) => $subTopic->mark_value >= LessonPlanTopic::where('id', $subTopic->sub_topic_id)->value('avg_marks'));

                    if ($topicPass && $subTopicPass) {
                        $result = 'Pass';
                    }
                    else{
                        $result = 'fail';
                    }
                }

                $subjects[$assignSubject->subject_id] = [
                    'subject' => $assignSubject->subject,
                    'students' => $marks->pluck('student_id')->unique(),
                    'lesson_count' => $lessonIds,
                    'lesson_totals' => $lessonTotals,
                    'overall_percentage' => $overallPercentage->overall_percpercentage ?? 0,
                    'totalMArk' => $totalMArk ?? 0,
                    'total_percentage_point' => $total_percentage_point ?? 0,
                    'result' => $result,
                ];
            }
            $student = StudentRecord::where('student_id', $studentId)
                ->with(['academic', 'student', 'section', 'class'])
                ->first();
            $mark_grade = SmMarksGrade::where([
                ['percent_from', '<=', (float)$grandTotalMarks],
                ['percent_upto', '>=', (float)$grandTotalMarks]
            ])
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->first();

            $result = $this->calculateResult($grandTotalPercentagePoint, count($subjects), $studentId, $assignSubjects);
            $totals = [
                'totalMarks' => number_format($grandTotalMarks, 2),
                'totalGradeValue' => $mark_grade->grade_name ?? 0,
                'totalPercentage' => number_format(($grandTotalMarks / (count($subjects)))),
                'result' => $result
            ];

            $pdf = PDF::loadView('programs.marksheet', [
                'student' => $student,
                'subjects' => $subjects,
                'totals' => $totals
            ]);
            $filename = 'students_report_' . $studentId . '.pdf';
            $pdfPath = storage_path('app/temp/' . $filename);
            if (!file_exists(dirname($pdfPath))) {
                mkdir(dirname($pdfPath), 0755, true);
            }
            $pdf->save($pdfPath);
            return $pdfPath;
        } catch (\Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage());
            throw $e;
        }
    }


    private function calculateResult($totalPoints, $subjectCount, $studentId, $assignSubjects)
    {
        foreach ($assignSubjects as $assignSubject) {
            $topics = SmStudentMarkRegister::whereNotNull('mark_value')
                ->whereIn('topic_id', SmLessonTopicDetail::whereNotNull('avg_marks')->pluck('id'))
                ->where('sub_topic_id', 0)
                ->where('student_id', $studentId)
                ->where('subject_id', $assignSubject->subject_id)
                ->get();

            foreach ($topics as $topic) {
                $avgMark = SmLessonTopicDetail::where('id', $topic->topic_id)->value('avg_marks');

                if ($topic->mark_value >= $avgMark) {
                    return 'Pass';
                } else {

                    return 'Fail';
                }
            }

            $subTopics = SmStudentMarkRegister::whereNotNull('mark_value')
                ->whereIn('sub_topic_id', LessonPlanTopic::whereNotNull('avg_marks')->pluck('id'))
                ->where('student_id', $studentId)
                ->where('subject_id', $assignSubject->subject_id)
                ->get();

            foreach ($subTopics as $subTopic) {
                $avgMark = LessonPlanTopic::where('id', $subTopic->sub_topic_id)->value('avg_marks');

                if ($subTopic->mark_value >= $avgMark) {
                    return 'Pass';
                } else {

                    return 'Fail';
                }
            }
            return 'Fail';
        }
    }

    public function ajaxClassMultipleSection(Request $request)
    {
        $sectionIds = SmClassSection::where('class_id', $request->id)->pluck('section_id');
        $promote_sections = SmSection::whereIn('id', $sectionIds)->get();
        return response()->json([$promote_sections]);
    }

    public function ajaxSectionStudent(Request $request)
    {
        $sectionIds = StudentRecord::where('section_id', $request->id)->pluck('student_id');
        $promote_sections = SmStudent::whereIn('id', $sectionIds)->get();
        return response()->json([$promote_sections]);
    }

    public function marktablePdf(Request $request)
    {
        $request->validate([
            'tableData' => 'required|array',
            'tableData.headers' => 'required|array',
            'tableData.rows' => 'required|array',
            'tableData.styles' => 'required|array'
        ]);
        $tableData = $request->input('tableData');
        $pdf = PDF::loadView('programs.marktable', compact('tableData'))
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'dpi' => 150,
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'isPhpEnabled' => true,
                'isFontSubsettingEnabled' => true,
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10
            ]);
        return $pdf->download('mark_table.pdf');
    }

    public function marktableText(Request $request)
    {
        $tableData = $request->input('tableData');

        $response = new StreamedResponse(function () use ($tableData) {
            $handle = fopen('php://output', 'w');


            foreach ($tableData['headers'] as $headerRow) {
                fputcsv($handle, $headerRow);
            }


            foreach ($tableData['rows'] as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text');
        $response->headers->set('Content-Disposition', 'attachment; filename="mark_table.text"');

        return $response;
    }

    public function marktableCsv(Request $request)
    {
        $tableData = $request->input('tableData');

        $response = new StreamedResponse(function () use ($tableData) {
            $handle = fopen('php://output', 'w');


            foreach ($tableData['headers'] as $headerRow) {
                fputcsv($handle, $headerRow);
            }


            foreach ($tableData['rows'] as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="mark_table.csv"');

        return $response;
    }
    public function downloadTableAsText(Request $request)
    {
        $tableData = $request->input('tableData');
        $fileName = 'mark_table.txt';
        Storage::disk('local')->put($fileName, $tableData);
        return response()->download(storage_path("app/{$fileName}"))->deleteFileAfterSend(true);
    }
}
