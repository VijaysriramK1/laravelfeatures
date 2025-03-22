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
            $table->string('completed_status')->nullable()->after('image');
            $table->date('competed_date')->nullable()->after('completed_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lesson_plan_topics', function (Blueprint $table) {
            $table->dropColumn('completed_status');
            $table->dropColumn('completed_date');
        });
    }
};
