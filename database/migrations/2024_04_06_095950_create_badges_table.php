<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->unsignedTinyInteger('active_status')->nullable()->default(1);
            $table->unsignedInteger('created_by')->nullable()->default(1)->unsigned();
            $table->unsignedInteger('updated_by')->nullable()->default(1)->unsigned();
            $table->unsignedInteger('school_id')->nullable()->default(1)->unsigned();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
        });

        Schema::table('student_records', function (Blueprint $table) {
            $table->foreignId('badge_id')->nullable()->constrained('badges');
        });

        Schema::table('sm_general_settings', function (Blueprint $table) {
            $table->unsignedTinyInteger('badge_system')->nullable()->default(0);
        });

        $classRoutines = array(
            'badges' => array(
                'module' => null,
                'sidebar_menu' => 'system_settings',
                'name' => 'Badges',
                'lang_name' => 'admin.badges',
                'icon' => null,
                'svg' => null,
                'route' => 'badges',
                'parent_route' => 'general_settings',
                'is_admin' => 1,
                'is_teacher' => 0,
                'is_student' => 0,
                'is_parent' => 0,
                'position' => 13,
                'is_saas' => 0,
                'is_menu' => 1,
                'status' => 1,
                'menu_status' => 1,
                'relate_to_child' => 0,
                'alternate_module' => null,
                'permission_section' => 0,
                'user_id' => null,
                'type' => 2,
                'old_id' => null,
            ),
        );

        foreach ($classRoutines as $item) {
            storePermissionData($item);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('badges');

        Schema::table('student_records', function (Blueprint $table) {
            $table->dropForeign('student_records_badge_id_foreign');
            $table->dropColumn(['badge_id']);
        });

        Schema::table('sm_general_settings', function (Blueprint $table) {
            $table->dropColumn(['badge_system']);
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
