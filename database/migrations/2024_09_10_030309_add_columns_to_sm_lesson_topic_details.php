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
        Schema::table('sm_lesson_topic_details', function (Blueprint $table) {
            $table->string('cgpa')->after('topic_title')->nullable();
            $table->string('unit')->after('cgpa')->nullable();
            $table->string('max_marks')->after('unit')->nullable();
            $table->string('avg_marks')->after('max_marks')->nullable();
            $table->string('image')->after('avg_marks')->nullable();
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sm_lesson_topic_details', function (Blueprint $table) {
            //
        });
    }
};
