<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionFeesInvoiceChields extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table='admission_fees_invoice_chields';
    public function invoice()
    {
        return $this->belongsTo(AdmissionFeesInvoice::class, 'admission_invoice_id');
    }
}
