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
            if (!Schema::hasColumn('lesson_plan_topics', 'sub_topic_title')) {
                $table->string('sub_topic_title')->after('id')->nullable();
            }
            if (!Schema::hasColumn('lesson_plan_topics', 'lesson_id')) {
                $table->integer('lesson_id')->after('subject_id')->nullable();
            }
            if (!Schema::hasColumn('lesson_plan_topics', 'parent_topic_id')) {
                $table->integer('parent_topic_id')->after('topic_id')->nullable();
               
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lesson_plan_topics', function (Blueprint $table) {
            if (Schema::hasColumn('lesson_plan_topics', 'sub_topic_title')) {
                $table->dropColumn('sub_topic_title');
            }
            if (Schema::hasColumn('lesson_plan_topics', 'lesson_id')) {
                $table->dropColumn('lesson_id');
            }
            if (Schema::hasColumn('lesson_plan_topics', 'parent_topic_id')) {
                $table->dropColumn('parent_topic_id');
            }
        });
    }
};
