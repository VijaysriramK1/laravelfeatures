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
            'unapproved_students' => array(
                'module' => null,
                'sidebar_menu' => 'student_info',
                'name' => 'Unapproved Students',
                'lang_name' => 'Unapproved Students',
                'icon' => null,
                'svg' => null,
                'route' => 'unapproved_students',
                'parent_route' => 'student_info',
                'is_admin' => 1,
                'is_teacher' => 0,
                'is_student' => 0,
                'is_parent' => 0,
                'position' => 17,
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
        Schema::dropIfExists('unapproved_student');
    }
};
