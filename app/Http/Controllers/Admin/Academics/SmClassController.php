<?php

namespace App\Http\Controllers\Admin\Academics;

use App\SmClass;
use App\SmSection;
use App\tableList;
use App\YearCheck;
use App\ApiBaseMethod;
use App\SmClassSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\Academics\ClassRequest;
use App\SmAssignSubject;
use App\SmSubject;
use Modules\Lesson\Entities\LessonPlanTopic;
use Modules\Lesson\Entities\SmLesson;
use Modules\Lesson\Entities\SmLessonTopic;
use Modules\Lesson\Entities\SmLessonTopicDetail;

class SmClassController extends Controller
{
    public $date;

    public function __construct()
    {
        $this->middleware('PM');
    }


    public function index(Request $request)
    {
        try {
            $sections = SmSection::query();
            if (moduleStatusCheck('University')) {
                $data = $sections->where('un_academic_id', getAcademicId());
            } else {
                $data = $sections->where('academic_id', getAcademicId());
            }
            $sections = $data->where('school_id', auth()->user()->school_id)->get();
            $classes = SmClass::with('groupclassSections')->withCount('records')->get();


            return view('backEnd.academics.class', compact('classes', 'sections'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function store(ClassRequest $request)
    {
        // DB::beginTransaction();
        try {
            $class = new SmClass();
            $class->class_name = $request->name;
            $class->pass_mark = $request->pass_mark;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/class_images'), $filename);
                $class->image = 'uploads/class_images/' . $filename;
            }

            $class->created_at = YearCheck::getYear() . '-' . date('m-d h:i:s');
            $class->created_by = auth()->user()->id;
            $class->school_id = Auth::user()->school_id;
            $class->academic_id = getAcademicId();
            $class->save();
            $class->toArray();

            foreach ($request->section as $section) {
                $smClassSection = new SmClassSection();
                $smClassSection->class_id = $class->id;
                $smClassSection->section_id = $section;
                $smClassSection->created_at = YearCheck::getYear() . '-' . date('m-d h:i:s');
                $smClassSection->school_id = Auth::user()->school_id;
                $smClassSection->academic_id = getAcademicId();
                $smClassSection->save();
            }
            // DB::commit();
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {

            // DB::rollBack();                
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $classById = SmCLass::find($id);
            $sectionByNames = SmClassSection::select('section_id')->where('class_id', '=', $classById->id)->get();
            $sectionId = array();
            foreach ($sectionByNames as $sectionByName) {
                $sectionId[] = $sectionByName->section_id;
            }

            $sections = SmSection::where('active_status', '=', 1)->where('created_at', 'LIKE', '%' . $this->date . '%')->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();

            $classes = SmClass::where('active_status', '=', 1)->orderBy('id', 'desc')->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->withCount('records')->get();
            return view('backEnd.academics.class', compact('classById', 'classes', 'sections', 'sectionId'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function update(ClassRequest $request)
    {
        SmCLassSection::where('class_id', $request->id)->delete();
        DB::beginTransaction();

        try {
            $class = SmCLass::find($request->id);
            $class->class_name = $request->name;
            if ($request->hasFile('image')) {
                if ($class->image) {
                    $oldImagePath = public_path('uploads/class_images/' . $class->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/class_images'), $filename);
                $class->image = 'uploads/class_images/' . $filename;
            }

            $class->pass_mark = $request->pass_mark;
            $class->save();
            $class->toArray();
            try {
                foreach ($request->section as $section) {
                    $smClassSection = new SmClassSection();
                    $smClassSection->class_id = $class->id;
                    $smClassSection->section_id = $section;
                    $smClassSection->created_at = YearCheck::getYear() . '-' . date('m-d h:i:s');
                    $smClassSection->school_id = Auth::user()->school_id;
                    $smClassSection->academic_id = getAcademicId();
                    $smClassSection->save();
                }

                DB::commit();

                if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                    return ApiBaseMethod::sendResponse(null, 'Class has been updated successfully');
                }
                Toastr::success('Operation successful', 'Success');
                return redirect('class');
            } catch (\Exception $e) {
                DB::rollBack();
            }
        } catch (\Exception $e) {
            DB::rollBack();
        }

        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            return ApiBaseMethod::sendError('Something went wrong, please try again.');
        }
        Toastr::error('Operation Failed', 'Failed');
        return redirect()->back();
    }

    public function delete(Request $request, $id)
    {
        try {
            $tables = tableList::getTableList('class_id', $id);

            if ($tables == null || $tables == "Class sections, ") {

                DB::beginTransaction();

                // $class_sections = SmClassSection::where('class_id', $id)->get();
                $class_sections = SmClassSection::where('class_id', $id)->get();
                foreach ($class_sections as $key => $class_section) {
                    SmClassSection::destroy($class_section->id);
                }
                $section = SmClass::destroy($id);
                DB::commit();
                if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                    if ($section) {
                        return ApiBaseMethod::sendResponse(null, 'Class has been deleted successfully');
                    } else {
                        return ApiBaseMethod::sendError('Something went wrong, please try again.');
                    }
                }

                Toastr::success('Operation successful', 'Success');
                return redirect('class');
            } else {
                DB::rollback();
                $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                Toastr::error($msg, 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function clone(Request $request, $id)
    {
        
        try {
            $classById = SmCLass::find($id);
           
          
            return view('backEnd.academics.class-clone', compact('classById'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function subjectclone(Request $request, $id)
    {
        try {
            $subjectId=SmSubject::find($id);
            return view('backEnd.academics.class-clone', compact('subjectId'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function lessonclone($class_id, $section_id, $subject_id)
    {
        try {
            $lessonId = SmLesson::where('class_id', $class_id)
                                ->where('section_id', $section_id)
                                ->where('subject_id', $subject_id)
                                ->get(); 
    
            return view('backEnd.academics.class-clone', compact( 'lessonId'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    
    public function TopicClone($id)
    {
        try {
            $data = SmLessonTopicDetail::where('topic_id', $id)->where('academic_id', getAcademicId())
                 ->where('school_id', Auth::user()->school_id)->get();
             
    
            return view('backEnd.academics.class-clone', compact( 'data'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function subtopics(Request $request, $id)
    {
        try {
            $subTopicDetails = LessonPlanTopic::where('topic_id', $id)->get();
            return view('backEnd.academics.class-clone',compact('subTopicDetails'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function save_clone(Request $request)
    {
        DB::beginTransaction();
       
      
        try {
            $clone = SmClass::find($request->id);
            $class = new SmClass();
            $class->class_name = $clone->class_name . ' (' . $request->start_date . ' )- (' . $request->end_date . ')';
            $class->pass_mark = $request->pass_mark;
            $class->parent_id = $clone->id;
            $class->created_at = YearCheck::getYear() . '-' . date('m-d h:i:s');
            $class->created_by = auth()->user()->id;
            $class->school_id = Auth::user()->school_id;
            $class->academic_id = getAcademicId();
            $class->save();
            $class->toArray();

           

            // $copy_items = [];
            // if ($request->copy_items != null) {
            //     $copy_items = implode(",", $request->copy_items);
            // }

            $sections = SmClassSection::where('active_status', 1)->where('class_id', $clone->id)->get();
            foreach ($sections as $section) {
                $smClassSection = new SmClassSection();
                $smClassSection->class_id = $class->id;
                $smClassSection->section_id = $section->section_id;
                $smClassSection->created_at = YearCheck::getYear() . '-' . date('m-d h:i:s');
                $smClassSection->school_id = Auth::user()->school_id;
                $smClassSection->academic_id = getAcademicId();
                $smClassSection->save();

                $subjects = SmAssignSubject::where('class_id', $section->class_id)->where('section_id', $section->section_id)->get();
                foreach ($subjects as $subject) {
                    $assign_subject = new SmAssignSubject();
                    $assign_subject->class_id = $class->id;
                    $assign_subject->school_id = $subject->school_id;
                    $assign_subject->section_id = $subject->section_id;
                    $assign_subject->subject_id = $subject->subject_id;
                    $assign_subject->teacher_id = $subject->teacher_id;
                    $assign_subject->created_at = YearCheck::getYear() . '-' . date('m-d h:i:s');
                    $assign_subject->academic_id = getAcademicId();
                    $assign_subject->save();
                }
            }

            DB::commit();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse(null, 'Class has been updated successfully');
            }
            Toastr::success('Operation successful', 'Success');
            return redirect('class');
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Failed');
            DB::rollBack();
        }

        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            return ApiBaseMethod::sendError('Something went wrong, please try again.');
        }
        Toastr::error('Operation Failed', 'Failed');
        return redirect()->back();
    }


    public function subject_clone(Request $request)
    {
      try{
        $cloneSubject = SmSubject::find($request->id);
        $newSubject = new SmSubject();
        $newSubject->subject_name = $cloneSubject->subject_name . ' (' . $request->start_date . ') - ( ' . $request->end_date . ')';
        $newSubject->subject_code=$cloneSubject->subject_code;
        $newSubject->image=$cloneSubject->image;
        $newSubject->duration=$cloneSubject->duration;
        $newSubject->duration_type=$cloneSubject->duration_type;
        $newSubject->pass_mark = $request->pass_mark;
        $newSubject->parent_id = $cloneSubject->id;
        $newSubject->created_at = YearCheck::getYear() . '-' . date('m-d h:i:s');
        $newSubject->created_by = auth()->user()->id;
        $newSubject->school_id = Auth::user()->school_id;
        $newSubject->academic_id = getAcademicId();
        $newSubject->save();
        // $subjectid=SmAssignSubject::where('subject_id',$cloneSubject->id)->get();
        // foreach ($subjectid as $subject) {
        //     $assign_subject = new SmAssignSubject();
        //     $assign_subject->class_id = $subject->class_id;
        //     $assign_subject->school_id = $subject->school_id;
        //     $assign_subject->section_id = $subject->section_id;
        //     $assign_subject->subject_id = $subject->subject_id;
        //     $assign_subject->teacher_id = $subject->teacher_id;
        //     $assign_subject->created_at = YearCheck::getYear() . '-' . date('m-d h:i:s');
        //     $assign_subject->academic_id = getAcademicId();
        //     $assign_subject->save();
        // }
        Toastr::success('Subject cloned successfully', 'Success');
        return redirect()->route('subject'); 
      }
      catch (\Exception $e) {
        Toastr::error($e->getMessage(), 'Failed');
        DB::rollBack();
    }
    }

    public function lesson_clone(Request $request)
    {
        $request->validate([
            'lesson' => 'required|array',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
    try{
        foreach ($request->lesson as $lessonId) {
            $cloneLesson = SmLesson::find($lessonId);
            if (!$cloneLesson) {
                Toastr::error('Lesson with ID ' . $lessonId . ' not found!', 'Error');
                return redirect()->back();
            }
            $newLesson = new SmLesson();
            $newLesson->lesson_title = $cloneLesson->lesson_title;
            $newLesson->subject_id = $cloneLesson->subject_id;
            $newLesson->start_date = $request->start_date;
            $newLesson->end_date = $request->end_date ;
            $newLesson->class_id = $cloneLesson->class_id;
            $newLesson->section_id = $cloneLesson->section_id;
            $newLesson->school_id = Auth::user()->school_id;
            $newLesson->academic_id = getAcademicId();
            $newLesson->save();
        }
        Toastr::success('Lessons cloned successfully!', 'Success');
        return redirect()->route('lesson'); 
    } catch (\Exception $e) {
        Toastr::error($e->getMessage(), 'Failed');
        DB::rollBack();
    }
    }
    
    public function topic_clone(Request $request)
    {
        DB::beginTransaction();
            foreach ($request->topic as $topicId) {
                $cloneTopic = SmLessonTopicDetail::find($topicId); 
                if (!$cloneTopic) {
                    Toastr::error('Topic with ID ' . $topicId . ' not found!', 'Error');
                    return redirect()->back();
                }
                $newTopic = new SmLessonTopicDetail(); 
                $newTopic->	topic_title = $cloneTopic->	topic_title . ' (' . $request->start_date . ' - ' . $request->end_date . ')';
                $newTopic->topic_id=$cloneTopic->topic_id??null;
                $newTopic->max_marks=$cloneTopic->max_marks;
                $newTopic->avg_marks=$cloneTopic->avg_marks;
                $newTopic->image=$cloneTopic->image;
                $newTopic->cgpa=$cloneTopic->cgpa;
                $newTopic->unit=$cloneTopic->unit;
                $newTopic->lesson_id = $cloneTopic->lesson_id;
                $newTopic->school_id = Auth::user()->school_id;
                $newTopic->academic_id = getAcademicId();
                $newTopic->save(); 
            }
            DB::commit();
            Toastr::success('Topics cloned successfully!', 'Success');
            return redirect('/lesson/topic');
       
    }

    public function subtopic_clone(Request $request)
    {
        DB::beginTransaction();
            foreach ($request->subtopic as $topicId) {
                $cloneTopic = LessonPlanTopic::find($topicId); 
                if (!$cloneTopic) {
                    Toastr::error('Topic with ID ' . $topicId . ' not found!', 'Error');
                    return redirect()->back();
                }
                $newTopic = new LessonPlanTopic(); 
                $newTopic->	sub_topic_title = $cloneTopic->	sub_topic_title . ' (' . $request->start_date . ' - ' . $request->end_date . ')';
                $newTopic->topic_id=$cloneTopic->topic_id??null;
                $newTopic->image=$cloneTopic->image;
                $newTopic->max_marks=$cloneTopic->max_marks;
                $newTopic->avg_marks=$cloneTopic->avg_marks;
                $newTopic->subject_id = $cloneTopic->subject_id;
                $newTopic->class_id = $cloneTopic->class_id;
                $newTopic->section_id = $cloneTopic->section_id;
                $newTopic->lesson_id = $cloneTopic->lesson_id;
                $newTopic->school_id = Auth::user()->school_id;
                $newTopic->academic_id = getAcademicId();
                $newTopic->save(); 
            }
            DB::commit();
            Toastr::success('Topics cloned successfully!', 'Success');
            return redirect()->route('sub-topic'); 
       
    }
    
    
}
