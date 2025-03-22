<?php

namespace App\View\Components;

use App\SmParent;
use Illuminate\View\Component;
use App\Traits\SidebarDataStore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\MenuManage\Entities\Sidebar;
use Modules\RolePermission\Entities\Permission;
use Modules\MenuManage\Entities\AlternativeModule;
use Modules\MenuManage\Entities\PermissionSection;
use Modules\RolePermission\Entities\AssignPermission;

class SidebarComponent extends Component
{
    use SidebarDataStore;
    public function __construct()
    {
        //
    }

    public function render()
    {
        $check_role_based_module_permission = AssignPermission::where('role_id', Auth::user()->role_id)
        ->where('school_id', Auth::user()->school_id)
        ->pluck('permission_id');

        $get_authorized_modules_details = Permission::whereIn('id', $check_role_based_module_permission)
        ->where('school_id', Auth::user()->school_id)
        ->where('type', '!=', 3)
        ->get();

        foreach ($get_authorized_modules_details as $value) {
            $get_authorized_data[] = $value->route;
        }
        
        if (Auth::user()->role_id == 1) {
            return view('sidebar.admin_sidebar');
        } else if (Auth::user()->role_id == 2) {
            return view('sidebar.student_sidebar');
        } else if (Auth::user()->role_id == 3) {
            return view('sidebar.parent_sidebar');
        } else if (Auth::user()->role_id == 5) {
            return view('sidebar.admin_sidebar');
        } else {
            return view('sidebar.other_sidebar', compact('get_authorized_data'));
        }
    }
}
