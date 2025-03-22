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
        Schema::create('admission_fees', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->unsignedInteger('class_id')->nullable(); 
            $table->foreign('class_id')->references('id')->on('sm_classes')->onDelete('cascade');
            $table->string('payment_method')->nullable();
            $table->string('amount')->nullable();
            $table->string('status')->nullable();
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('fees_group_id')->nullable()->default(1); 
            $table->foreign('fees_group_id')->references('id')->on('sm_fees_groups')->onDelete('cascade');
            $table->unsignedInteger('course_id')->nullable()->comment('Only For Lms');
            $table->foreign('course_id')->references('id')->on('sm_courses')->onDelete('cascade');
            $table->unsignedInteger('school_id')->nullable()->default(1); 
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
            $table->unsignedInteger('academic_id')->nullable()->default(1); 
            $table->foreign('academic_id')->references('id')->on('sm_academic_years')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_fees');
    }
};
