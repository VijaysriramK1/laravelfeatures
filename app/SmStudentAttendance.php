<?php

namespace App;

use App\Scopes\AcademicSchoolScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmStudentAttendance extends Model
{
    use HasFactory;
    protected $table = "sm_student_attendances";

    protected $fillable = [
        'attendance_type',
        'notes',
        'attendance_date',
        'student_id',
        'record_id',
        'student_record_id',
        'class_id',
        'section_id',
        'school_id',
        'academic_id',
        'active_status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new AcademicSchoolScope);
    }
    public function studentInfo()
    {
        return $this->belongsTo('App\SmStudent', 'student_id', 'id');
    }
    public function scopemonthAttendances($query, $month)
    {
        return $query->whereMonth('attendance_date', $month);
    }
}
