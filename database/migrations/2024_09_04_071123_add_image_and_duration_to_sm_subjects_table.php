<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageAndDurationToSmSubjectsTable extends Migration
{
    public function up()
    {
        Schema::table('sm_subjects', function (Blueprint $table) {
            if (!Schema::hasColumn('sm_subjects', 'image')) {
                $table->string('image')->nullable()->after('subject_code');
            }
            if (!Schema::hasColumn('sm_subjects', 'duration')) {
                $table->integer('duration')->nullable()->after('image');
            }
            if (!Schema::hasColumn('sm_subjects', 'duration_type')) {
                $table->string('duration_type')->default('minutes')->after('duration');
            }
        });
    }

    public function down()
    {
        Schema::table('sm_subjects', function (Blueprint $table) {
            if (Schema::hasColumn('sm_subjects', 'image')) {
                $table->dropColumn('image');
            }
            if (Schema::hasColumn('sm_subjects', 'duration')) {
                $table->dropColumn('duration');
            }
            if (Schema::hasColumn('sm_subjects', 'duration_type')) {
                $table->dropColumn('duration_type');
            }
        });
    }
}
