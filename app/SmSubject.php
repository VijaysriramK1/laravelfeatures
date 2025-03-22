<?php

namespace App;

use App\Scopes\GlobalAcademicScope;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\StatusAcademicSchoolScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Lesson\Entities\SmLesson;

class SmSubject extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new GlobalAcademicScope);
        static::addGlobalScope(new StatusAcademicSchoolScope);
    }

    public function lessons()
    {
        return $this->hasMany(SmLesson::class, 'subject_id', 'id');
    }

    public function assignedSubject()
    {
        return $this->hasOne(SmAssignSubject::class, 'subject_id');
    }

    public function teacher()
    {
        return $this->belongsTo(SmStaff::class, 'teacher_id');
    }

    //

}
