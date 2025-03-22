<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fm_fees_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('admission_invoice_id')->nullable()->after('fees_invoice_id')->unsigned();
            $table->foreign('admission_invoice_id')->references('id')->on('admission_fees_invoices')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fm_fees_transactions', function (Blueprint $table) {
            $table->dropForeign(['admission_invoice_id']);
            $table->dropColumn('admission_invoice_id');
        });
    }
};
