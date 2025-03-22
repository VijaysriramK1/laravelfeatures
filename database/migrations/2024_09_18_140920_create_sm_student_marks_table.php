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
        Schema::create('sm_student_marks', function (Blueprint $table) {
            $table->id();

            $table->string('student_id')->nullable();
            $table->string('class_id')->nullable();
            $table->string('section_id')->nullable();
            $table->string('subject_id')->nullable();
            $table->string('topic_id')->nullable();
            $table->string('sub_topic_id')->nullable();
            $table->string('lesson_id')->nullable();
            $table->string('user_id')->nullable();
            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');

            $table->integer('academic_id')->nullable()->default(1)->unsigned();
            $table->foreign('academic_id')->references('id')->on('sm_academic_years')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sm_student_marks');
    }
};
