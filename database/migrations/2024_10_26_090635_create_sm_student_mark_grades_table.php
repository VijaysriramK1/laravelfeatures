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
        Schema::create('sm_student_mark_grades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_roll_no')->default(1); 
            $table->integer('student_addmission_no')->default(1); 
            $table->integer('is_absent')->default(0)->comment('1=Absent, 0=Present'); 
            $table->float('total_marks')->default(0); 
            $table->float('total_gpa_point')->nullable(); 
            $table->string('total_gpa_grade',255)->default(0)->nullable(); 
            $table->text('teacher_remarks')->nullable();
            $table->timestamps();

            $table->integer('exam_type_id')->nullable()->unsigned();
          
            $table->integer('subject_id')->nullable()->unsigned();
           
            $table->integer('active_status')->nullable()->default(1);

            $table->integer('student_id')->nullable()->unsigned();
        
            $table->bigInteger('student_record_id')->nullable()->unsigned();
        
            $table->integer('class_id')->nullable()->unsigned();

            $table->integer('section_id')->nullable()->unsigned();
         
            $table->integer('created_by')->nullable()->default(1)->unsigned();

            $table->integer('updated_by')->nullable()->default(1)->unsigned();

            $table->integer('school_id')->nullable()->default(1)->unsigned();
           
            $table->integer('academic_id')->nullable()->default(1)->unsigned();

            
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sm_student_mark_grades');
    }
};
