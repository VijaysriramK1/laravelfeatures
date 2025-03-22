<?php

namespace App\Models;

use App\SmClass;
use App\SmStaff;
use App\SmSection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmStudentAttendanceRequest extends Model
{
    use HasFactory;

    protected $table = 'sm_student_attendance_request';

    protected $fillable = [
        'request_notes',
        'attendance_date',
        'request_status',
        'staff_id',
        'class_id',
        'section_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(SmStaff::class, 'staff_id', 'id');
    }

    public function class()
    {
        return $this->belongsTo(SmClass::class, 'class_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(SmSection::class, 'section_id', 'id');
    }
}
