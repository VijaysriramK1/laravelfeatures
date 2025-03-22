<?php

namespace Modules\Lesson\Entities;

use App\Scopes\StatusAcademicSchoolScope;
use App\SmAssignSubject;
use App\SmSubject;
use Illuminate\Database\Eloquent\Model;

class SmLessonTopicDetail extends Model
{

    protected $fillable = [];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new StatusAcademicSchoolScope);
    }

    public function lesson_title()
    {
        return $this->belongsTo('Modules\Lesson\Entities\SmLesson', 'lesson_id');
    }

    public function lessonPlan()
    {
        return $this->hasMany('Modules\Lesson\Entities\LessonPlanTopic', 'topic_id', 'id');
    }

    public function subTopics()
    {
        return $this->hasMany(LessonPlanTopic::class, 'topic_id');
    }

    public function topicName()
    {
        return $this->belongsTo(SmLessonTopic::class, 'topic_id');
    }

    public function topics()
    {
        return $this->belongsTo('Modules\Lesson\Entities\SmLessonTopicDetail', 'topic_id', 'topic_id');
    }

    public function subject()
    {
        return $this->belongsTo(SmSubject::class, 'subject_id');
    }
}
