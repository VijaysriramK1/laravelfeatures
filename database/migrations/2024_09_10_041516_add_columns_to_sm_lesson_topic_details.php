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
            $table->boolean('is_sub_topic_enabled')->after('active_status')->default(0);
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
