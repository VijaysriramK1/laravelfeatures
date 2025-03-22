<?php

namespace Modules\MenuManage\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\SidebarDataStore;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\MenuManage\Entities\Sidebar;
use Modules\MenuManage\Entities\SidebarNew;
use Illuminate\Contracts\Support\Renderable;
use Modules\RolePermission\Entities\SmaRole;
use Modules\RolePermission\Entities\Permission;
use Modules\MenuManage\Entities\PermissionSection;
use Modules\RolePermission\Entities\SmaModuleInfo;
use Modules\RolePermission\Entities\AssignPermission;
use Modules\RolePermission\Entities\SmaPermissionAssign;
use Modules\RolePermission\Entities\SmaModuleStudentParentInfo;

class MenuManageController extends Controller
{
    use SidebarDataStore;
    public function __construct()
    {
        $this->middleware('PM');
    }

    public function index()
    {
        $data = [];
        Cache::forget('sidebars' . auth()->user()->id);
        $data['unused_menus'] = SidebarManagerController::unUsedMenu();
        $data['sidebar_menus'] = sidebar_menus();
        $data['permission_sections'] = Permission::where('user_id', auth()->user()->id)->pluck('id')->toArray();

        return view('menumanage::index', $data);
    }


    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $checked_ids = $request->module_id;
            SidebarNew::where('user_id', $user->id)->where('role_id', $user->role_id)->delete();
            foreach ($request->all_modules_id as $key => $id) {
                $status = in_array($id, $checked_ids) ? 1 : 0;
                $sidebar = new SidebarNew;
                $sidebar->sma_module_id = $id;
                if ($user->role_id == 2 || $user->role_id == 3) {
                    $student_p = SmaModuleStudentParentInfo::find($id);
                    $sidebar->module_id = $student_p ? $student_p->module_id : ' ';
                    $sidebar->route = $student_p ? $student_p->route : ' ';
                    $sidebar->name = $student_p ? $student_p->name : ' ';
                    $sidebar->parent_id = $student_p ? $student_p->parent_id : ' ';
                    $sidebar->type = $student_p ? $student_p->type : ' ';
                } else {
                    $sma_module = SmaModuleInfo::find($id);
                    $sidebar->module_id = $sma_module ? $sma_module->module_id : ' ';
                    $sidebar->route = $sma_module ? $sma_module->route : ' ';
                    $sidebar->name = $sma_module ? $sma_module->name : ' ';
                    $sidebar->parent_id = $sma_module ? $sma_module->parent_id : ' ';
                    $sidebar->type = $sma_module ? $sma_module->type : ' ';
                }
                $sidebar->role_id = auth()->user()->role_id;
                $sidebar->user_id = auth()->user()->id;
                $sidebar->school_id = auth()->user()->school_id;
                $sidebar->active_status = $status;
                $sidebar->parent_position_no = $key;
                $sidebar->child_position_no = $key;
                $sidebar->save();
            }


            Toastr::success('Successfully Insert', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Operation Failed', 'Error');
            return redirect()->back();
        }
    }

    public function manage()
    {

        $id = Auth::user()->role_id;
        $role = SmaRole::where('is_saas', 0)->where('id', $id)->first();
        $all_modules = SmaModuleInfo::where('is_saas', 0)->where('active_status', 1)->get();
        $all_modules = $all_modules->groupBy('module_id');
        $all_sidebars = SidebarNew::where('is_saas', 0)->distinct('module_id')->get();
        return view('menumanage::all_sidebar_menu', compact('role', 'all_modules', 'all_sidebars'));
    }

    public function reset()
    {
        try {
            $user = Auth::user();
            Sidebar::where('user_id', $user->id)->where('role_id', $user->role_id)->delete();
            $this->defaultStore();
            Toastr::success('Operation Successful', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
