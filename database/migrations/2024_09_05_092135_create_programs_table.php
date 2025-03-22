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
        $downloadCenter = [
            'program' => array(
                'module' => null,
                'sidebar_menu' => null,
                'name' => 'Program',
                'lang_name' => 'Program',
                'icon' => 'fas fa-book',
                'svg' => null,
                'route' => 'program',
                'parent_route' => null,
                'is_admin' => 1,
                'is_teacher' => 1,
                'is_student' => 1,
                'is_parent' => 0,
                'position' => 6,
                'is_saas' => 0,
                'is_menu' => 1,
                'status' => 1,
                'menu_status' => 1,
                'relate_to_child' => 0,
                'alternate_module' => null,
                'permission_section' => 0,
                'user_id' => null,
                'type' => 1,
                'old_id' => null,
                'child' => array(
                    'programs.myprograms' => array(
                        'module' => null,
                        'sidebar_menu' => null,
                        'name' => 'My Program',
                        'lang_name' => 'My Program',
                        'icon' => null,
                        'svg' => null,
                        'route' => 'programs.myprograms',
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
                    'Mark' => array(
                        'module' => null,
                        'sidebar_menu' => null,
                        'name' => 'Mark',
                        'lang_name' => 'Mark',
                        'icon' => null,
                        'svg' => null,
                        'route' => 'programs.mark',
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
                    'My Student' => array(
                        'module' => null,
                        'sidebar_menu' => null,
                        'name' => 'My Student',
                        'lang_name' => 'My Student',
                        'icon' => null,
                        'svg' => null,
                        'route' => 'programs.my-student',
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
                    'Routines' => array(
                        'module' => null,
                        'sidebar_menu' => null,
                        'name' => 'Routines',
                        'lang_name' => 'Routines',
                        'icon' => null,
                        'svg' => null,
                        'route' => 'programs.routines',
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
                ),
            ),
        ];
        foreach ($downloadCenter as $menu) {
            storePermissionData($menu);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
