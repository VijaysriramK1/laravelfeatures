<?php

namespace App\Models;

use App\SmClass;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use PhpParser\Node\Expr\Cast;


    class AdmissionFees extends Model
    {
        use HasFactory;
        protected $table='admission_fees';
        protected $fillable = ['title','class_id','payment_method','amount','status','user_id','fees_group_id','course_id','school_id','academic_id'];
        public function class()
        {
            return $this->belongsTo(SmClass::class, 'class_id');
        }
        // protected $casts = [
        //     'class_id' => 'array',
        // ];
    }