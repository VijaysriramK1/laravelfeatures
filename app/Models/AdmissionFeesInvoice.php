<?php

namespace App\Models;

use App\SmAdmissionQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionFeesInvoice extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table='admission_fees_invoices';
    public function studentInfo()
    {
        return $this->belongsTo(SmAdmissionQuery::class,'student_id','id');
    }
    public function invoiceDetails()
    {
        return $this->hasMany(AdmissionFeesInvoiceChields::class,'admission_fees_invoice_id');
    }

    public function getTamountAttribute()
    {
        return $this->invoiceDetails()->sum('amount');
    }

    public function getTweaverAttribute()
    {
        return $this->invoiceDetails()->sum('weaver');
    }

    public function getTfineAttribute()
    {
        return $this->invoiceDetails()->sum('fine');
    }

    public function getTpaidamountAttribute()
    {
        return $this->invoiceDetails()->sum('paid_amount');
    }

    public function getTsubtotalAttribute()
    {
        return $this->invoiceDetails()->sum('sub_total');
    }

    public function recordDetail(){
        return $this->belongsTo(AdmissionFees::class, 'admission_fees_id', 'id');
    }

}
