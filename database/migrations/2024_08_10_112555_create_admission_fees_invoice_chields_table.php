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
        Schema::create('admission_fees_invoice_chields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admission_fees_id')->nullable()->unsigned();
            $table->foreign('admission_fees_id')->references('id')->on('admission_fees_invoices')->onDelete('cascade');
            $table->integer('fees_type')->nullable();
            $table->float('amount')->nullable();
            $table->float('weaver')->nullable();
            $table->float('fine')->nullable();
            $table->float('sub_total')->nullable();
            $table->float('paid_amount')->nullable();
            $table->float('service_charge')->nullable();
            $table->float('due_amount')->nullable();
            $table->string('note')->nullable();
            $table->integer('school_id')->nullable();
            $table->integer('academic_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_fees_invoice_chields');
    }
};
