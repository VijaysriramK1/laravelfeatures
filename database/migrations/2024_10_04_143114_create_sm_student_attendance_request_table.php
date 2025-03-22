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
        Schema::create('sm_student_attendance_request', function (Blueprint $table) {
            $table->id();
            $table->string('request_notes')->nullable();
            $table->date('attendance_date')->nullable();
            $table->string('request_status')->nullable();
            $table->unsignedInteger('staff_id')->nullable();
            $table->foreign('staff_id')->references('id')->on('sm_staffs')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('class_id')->nullable();
            $table->foreign('class_id')->references('id')->on('sm_classes')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('section_id')->nullable();
            $table->foreign('section_id')->references('id')->on('sm_sections')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sm_student_attendance_request');
    }
};
