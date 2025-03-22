<?php

namespace App\Models;

use App\SmAdmissionQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmAdmissionQueryReminder extends Model
{

    use HasFactory;

    protected $table = 'sm_admission_queries_reminders';

    protected $fillable = [
        'admission_query_id',
        'reminder_at',
        'reminder_notes',
        'is_notify',
    ];

    protected $casts = [
        'reminder_at' => 'datetime',
        'is_notify' => 'boolean',
    ];

    public function admissionQuery()
    {
        return $this->belongsTo(SmAdmissionQuery::class, 'admission_query_id');
    }
}
