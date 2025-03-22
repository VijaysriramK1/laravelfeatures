<?php

namespace App\Models;

use App\SmStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentScholarship extends Model
{
    use HasFactory;
    protected $table = 'student_scholarships';
    protected $guarded = [];
    protected $casts = [
        'awarded_date' => 'datetime',
    ];
   

    public function student()
    {
        return $this->belongsTo(SmStudent::class, 'student_id');
    }

    public function record()
    {
        return $this->belongsTo(StudentRecord::class, 'student_id', 'student_id');
    }
    public function Scholarship(){
        return $this->belongsTo(ScholarShips::class, 'scholarship_id', 'id');
    }
}
