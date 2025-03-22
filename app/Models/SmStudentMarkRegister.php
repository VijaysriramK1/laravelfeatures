<?php

namespace App\Models;

use App\SmClass;
use App\SmStudent;
use App\SmSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Lesson\Entities\LessonPlanTopic;
use Modules\Lesson\Entities\SmLesson;
use Modules\Lesson\Entities\SmLessonTopic;

class SmStudentMarkRegister extends Model
{
    use HasFactory;
    protected $table = 'sm_student_mark_registers';
    protected $guarded = [];
    public function studentMark(){
        return $this->belongsTo(SmStudentMark::class, 'student_mark_id', 'id');
    }
    public function student(){
        return $this->belongsTo(SmStudent::class, 'student_id', 'id');
    }
    public function class(){
        return $this->belongsTo(SmClass::class, 'class_id', 'id');
    }
    public function lesson(){
        return $this->belongsTo(SmLesson::class, 'lesson_id', 'id');
    }
    public function subject(){
        return $this->belongsTo(SmSubject::class, 'subject_id', 'id');
    }
    public function topic(){
        return $this->belongsTo(SmLessonTopic::class, 'topic_id', 'id');
    }
    public function subTopic(){
        return $this->belongsTo(LessonPlanTopic::class, 'sub_topic_id', 'id');
    }
}
