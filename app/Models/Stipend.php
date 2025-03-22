<?php

namespace App\Models;

use App\SmStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stipend extends Model
{
    use HasFactory;
    protected $table = 'stipends';
    protected $guarded = [];
    public function student()
    {
        return $this->belongsTo(SmStudent::class, 'student_id');
    }
    

    public function record()
    {
        return $this->belongsTo(StudentRecord::class, 'student_id', 'student_id');
    }
    
    public function scholarship(){
        return $this->belongsTo(ScholarShips::class, 'scholarship_id');
    }
}
