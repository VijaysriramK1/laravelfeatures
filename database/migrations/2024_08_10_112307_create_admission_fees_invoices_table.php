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
        Schema::create('admission_fees_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->integer('student_id') ->nullable()->unsigned();
            $table->foreign('student_id')->references('id')->on('sm_students')->onDelete('cascade');
            $table->integer('class_id')->nullable();
            $table->date('create_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_method')->nullable();
            $table->integer('bank_id')->nullable();
            $table->string('type')->default('fees')->nullable()->comment('fees, lms');
            $table->integer('school_id')->nullable();
            $table->integer('academic_id')->nullable();
            $table->integer('active_status')->nullable()->default(1);
            $table->timestamps();
            $table->unsignedBigInteger('admission_fees_id') ->nullable()->unsigned();
            $table->foreign('admission_fees_id')->references('id')->on('admission_fees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_fees_invoices');
    }
};
