<?php

namespace App;

use App\Scopes\GlobalAcademicScope;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\StatusAcademicSchoolScope;
use App\Models\SmStudentAttendanceRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmSection extends Model
{
    //
    use HasFactory;
    protected $guarded = [];
    protected static function boot()
    {
        parent::boot();
        // static::addGlobalScope(new GlobalAcademicScope);
        static::addGlobalScope(new StatusAcademicSchoolScope);
    }

    public function students()
    {
        return $this->hasMany('App\SmStudent', 'section_id', 'id');
    }
    public function unAcademic()
    {
        return $this->belongsTo('Modules\University\Entities\UnAcademicYear', 'un_academic_id', 'id')->withDefault();
    }

    public function attendanceRequest()
    {
        return $this->hasMany(SmStudentAttendanceRequest::class, 'section_id', 'id');
    }

    public function classes()
    {
        return $this->belongsToMany(SmClass::class, 'sm_class_sections', 'section_id', 'class_id');
    }
}
