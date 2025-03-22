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
        $set_details = array(
            'student_attendance_request' => array(
                'module' => null,
                'sidebar_menu' => 'student_info',
                'name' => 'Student Attendance Request',
                'lang_name' => 'Student Attendance Request',
                'icon' => null,
                'svg' => null,
                'route' => 'student_attendance_request',
                'parent_route' => 'student_info',
                'is_admin' => 1,
                'is_teacher' => 0,
                'is_student' => 0,
                'is_parent' => 0,
                'position' => 8,
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

        foreach ($set_details as $item) {
            storePermissionData($item);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_attendance_request');
    }
};
