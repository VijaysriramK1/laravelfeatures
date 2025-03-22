<?php

namespace App\Models;

use App\SmClass;
use App\SmStudent;
use App\SmSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Lesson\Entities\LessonPlanTopic;
use Modules\Lesson\Entities\SmLesson;
use Modules\Lesson\Entities\SmLessonDetails;
use Modules\Lesson\Entities\SmLessonTopic;
use Modules\Lesson\Entities\SmLessonTopicDetail;

class SmStudentMark extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lesson_title()
    {
        return $this->belongsTo(SmLesson::class, 'lesson_id');
    }

    public function topics()
    {
        return $this->hasMany(SmLessonTopicDetail::class, 'lesson_id', 'lesson_id');
    }

    public function subTopics()
    {
        return $this->hasMany(LessonPlanTopic::class, 'topic_id', 'lesson_planner_id');
    }
    public function studentMark()
    {
        return $this->belongsTo(SmStudentMark::class, 'student_mark_id', 'id');
    }
    public function student()
    {
        return $this->belongsTo(SmStudent::class, 'student_id', 'id');
    }
    public function class()
    {
        return $this->belongsTo(SmClass::class, 'class_id', 'id');
    }
    public function lesson()
    {
        return $this->belongsTo(SmLesson::class, 'lesson_id', 'id');
    }
    public function subject()
    {
        return $this->belongsTo(SmSubject::class, 'subject_id', 'id');
    }
    public function topic()
    {
        return $this->belongsTo(SmLessonTopic::class, 'topic_id', 'id');
    }
    public function subTopic()
    {
        return $this->belongsTo(LessonPlanTopic::class, 'sub_topic_id', 'id');
    }
    public function studentmarks(){
        return $this->belongsTo(SmStudentMarkRegister::class, 'student_mark_id');
    }
    public function academicYear()
    {
        return $this->belongsTo('App\SmAcademicYear', 'academic_id', 'id');
    }
    public function section()
    {
      
            return $this->belongsTo('App\SmSection', 'section_id', 'id');
      
    }
}
