<?php

namespace App\Models;

use App\SmStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StipendPayment extends Model
{
    use HasFactory;
    protected $table = 'stipend_payments';
    protected $guarded = [];
    public function stipends()
    {
        return $this->belongsTo(Stipend::class, 'stipend_id', 'id');
    }
  
    public function student()
    {
        return $this->belongsTo(SmStudent::class, 'student_id');
    }
    
   


    public function record()
    {
        return $this->belongsTo(StudentRecord::class, 'student_id', 'student_id');
    }
}
