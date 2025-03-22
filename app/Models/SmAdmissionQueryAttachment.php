<?php

namespace App\Models;

use App\SmAdmissionQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmAdmissionQueryAttachment extends Model
{
    use HasFactory;

    protected $fillable = ['admission_query_id', 'file_name', 'file_path'];

    public function admissionQuery()
    {
        return $this->belongsTo(SmAdmissionQueryAttachment::class, 'admission_query_id');
    }
}
