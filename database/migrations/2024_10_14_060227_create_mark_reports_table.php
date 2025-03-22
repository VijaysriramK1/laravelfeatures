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
        $classRoutines = array(
            'mark_report' => array(
                'module' => null,
                'sidebar_menu' => 'program',
                'name' => 'Mark Report',
                'lang_name' => 'Mark Report',
                'icon' => null,
                'svg' => null,
                'route' => 'mark-report',
                'parent_route' => 'program',
                'is_admin' => 1,
                'is_teacher' => 1,
                'is_student' => 1,
                'is_parent' => 0,
                'position' => 1,
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
                'child' => null,
            ),
        );

        foreach ($classRoutines as $item) {
            storePermissionData($item);
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
