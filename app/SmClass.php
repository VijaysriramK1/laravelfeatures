<?php

namespace App;

use App\Models\AdmissionFees;
use App\Models\StudentRecord;
use App\Scopes\GlobalAcademicScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\StatusAcademicSchoolScope;
use App\Models\SmStudentAttendanceRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\BehaviourRecords\Entities\AssignIncident;

class SmClass extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StatusAcademicSchoolScope);
        static::addGlobalScope(new GlobalAcademicScope);
    }


    public function classSection()
    {
        return $this->hasMany('App\SmClassSection', 'class_id')->with('sectionName');
    }
    public function classSectionAll()
    {
        return $this->belongsToMany('App\SmSection', 'sm_class_sections', 'class_id', 'section_id');
    }

    public function sectionName()
    {
        return $this->belongsTo('App\SmSection', 'section_id');
    }

    public function sections()
    {
        return $this->hasMany('App\SmSection', 'id', 'section_id');
    }

    public function records()
    {
        return $this->hasMany(StudentRecord::class, 'class_id', 'id')->where('is_promote', 0)->whereHas('student');
    }
    public function allIncident()
    {
        return $this->hasManyThrough(AssignIncident::class, StudentRecord::class, 'class_id', 'record_id', 'id', 'id');
    }

    public function classSections()
    {
        return $this->hasMany('App\SmClassSection', 'class_id', 'id');
    }
    public function groupclassSections()
    {
        return $this->hasMany('App\SmClassSection', 'class_id', 'id')->with('sectionName');
    }


    public function globalGroupclassSections()
    {
        return $this->hasMany('App\SmClassSection', 'class_id', 'id')->distinct(['class_id', 'section_id'])->withoutGlobalScope(GlobalAcademicScope::class)->withoutGlobalScope(StatusAcademicSchoolScope::class)->with('sectionName');
    }

    public function students()
    {
        return $this->hasMany('App\SmStudent', 'user_id', 'id');
    }

    public function subjects()
    {
        return $this->hasMany(SmAssignSubject::class, 'class_id')->withoutGlobalScope(GlobalAcademicScope::class)->withoutGlobalScope(StatusAcademicSchoolScope::class);
    }

    public function routineUpdates()
    {
        return $this->hasMany(SmClassRoutineUpdate::class, 'class_id')->where('active_status', 1);
    }

    public function academic()
    {
        return $this->belongsTo('App\SmAcademicYear', 'academic_id', 'id')->withDefault();
    }
    public function admissionFees()
    {
        return $this->hasMany(AdmissionFees::class, 'class_id');
    }
    public function studentInfo()
    {
        return $this->hasMany(AdmissionFees::class, 'class_id');
    }

    public function classTeachers()
    {
        return $this->hasMany(SmAssignClassTeacher::class, 'class_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(
            SmStaff::class,
            'sm_class_teachers',
            'assign_class_teacher_id',
            'teacher_id',
            'section_id',
        );
    }

    public function attendanceRequest()
    {
        return $this->hasMany(SmStudentAttendanceRequest::class, 'class_id', 'id');
    }
    public function sectionrecords()
    {
        return $this->hasMany(StudentRecord::class, 'section_id', 'id')->where('is_promote', 0)->whereHas('student');
    }
}
