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
        Schema::table('lesson_plan_topics', function (Blueprint $table) {
            $table->string('max_marks')->after('sub_topic_title')->nullable();
            $table->string('avg_marks')->after('max_marks')->nullable();
            $table->string('image')->after('avg_marks')->nullable();
            $table->integer('class_id')->after('image')->nullable();
            $table->integer('section_id')->after('class_id')->nullable();
            $table->integer('subject_id')->after('section_id')->nullable();
            $table->integer('school_id')->after('updated_at')->nullable();
            $table->integer('academic_id')->after('school_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lesson_plan_topics', function (Blueprint $table) {
            //
        });
    }
};
