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
            'scholarships' => array(
                'module' => null,
                'sidebar_menu' => null,
                'name' => 'scholarships',
                'lang_name' => 'Scholar Ships',
                'icon' =>'fas fa-graduation-cap',
                'svg' => null,
                'route' => 'scholarships',
                'parent_route' => null,
                'is_admin' => 1,
                'is_teacher' => 1,
                'is_student' => 1,
                'is_parent' => 1,
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
                    'scholarships.Add Scholarship' => array(
                        'module' => null,
                        'sidebar_menu' => null,
                        'name' => 'Add Scholarship',
                        'lang_name' => 'Add Scholarship',
                        'icon' => null,
                        'svg' => null,
                        'route' => 'add-scholarship',
                        'parent_route' => 'scholarships',
                        'is_admin' => 1,
                        'is_teacher' => 1,
                        'is_student' => 1,
                        'is_parent' => 1,
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
                    'Assign Student' => array(
                        'module' => null,
                        'sidebar_menu' => null,
                        'name' => 'Assign Student',
                        'lang_name' => 'Assign Student',
                        'icon' => null,
                        'svg' => null,
                        'route' => 'assign-student',
                        'parent_route' => 'scholarships',
                        'is_admin' => 1,
                        'is_teacher' => 1,
                        'is_student' => 1,
                        'is_parent' => 1,
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
                    'Add Stipend' => array(
                        'module' => null,
                        'sidebar_menu' => null,
                        'name' => 'Add Stipend',
                        'lang_name' => 'Add Stipend',
                        'icon' => null,
                        'svg' => null,
                        'route' => 'add-stipend',
                        'parent_route' => 'scholarships',
                        'is_admin' => 1,
                        'is_teacher' => 1,
                        'is_student' => 1,
                        'is_parent' => 1,
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
                    'Stipend Records' => array(
                        'module' => null,
                        'sidebar_menu' => null,
                        'name' => 'Stipend Records',
                        'lang_name' => 'Stipend Records',
                        'icon' => null,
                        'svg' => null,
                        'route' => 'stipend-records',
                        'parent_route' => 'scholarships',
                        'is_admin' => 1,
                        'is_teacher' => 1,
                        'is_student' => 1,
                        'is_parent' => 1,
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
    public function down(): void
    {
        
    }
};
