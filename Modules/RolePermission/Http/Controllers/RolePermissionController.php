<?php

namespace Modules\RolePermission\Http\Controllers;

use App\User;
use Validator;
use App\tableList;
use App\ApiBaseMethod;
use App\SmaModuleManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Modules\RolePermission\Entities\AssignPermission;
use Modules\RolePermission\Entities\SmaRole;
use Modules\RolePermission\Entities\Permission;
use Modules\RolePermission\Entities\SmaModuleInfo;
use Modules\RolePermission\Http\Requests\RoleRequest;
use Modules\RolePermission\Entities\SmaPermissionAssign;
use Modules\RolePermission\Entities\SmaModuleStudentParentInfo;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

        return view('rolepermission::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('rolepermission::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {

        return view('rolepermission::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('rolepermission::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function role(Request $request)
    {
        return view('rolepermission::role');
    }

    public function schoolBasedRoleList(Request $request)
    {
        if ($request->ajax()) {
            $data = SmaRole::where('school_id', Auth::user()->school_id)->whereNotIn('id', [1, 5, 6, 7, 8, 9])->orderBy('id', 'asc')->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {

                    if ($row->id == 2 || $row->id == 3 || $row->id == 4) {
                        $add_extra_content = '';
                    } else {
                        $add_extra_content = '<a class="dropdown-item" data-toggle="modal" data-target="#deleteRole' . $row->id . '">' . __('common.delete') . '</a>';
                    }
                    $setUrl = url('/rolepermission/assign-permission/' . $row->id);
                    $content = '<div class="dropdown CRM_dropdown">
                                     <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">' . __('common.select') . '</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                      <a class="dropdown-item" href="role-edit/' . $row->id . '">' . __('common.edit') . '</a>
                                      ' . $add_extra_content . '
                                    </div>
                                    <a href="' . $setUrl . '" class="">
                                       <button type="button" class="primary-btn small fix-gr-bg text-nowrap">' . __('rolepermission::role.assign_permission') . '</button>
                                    </a>
                                </div>
                                <div class="modal fade admin-query" id="deleteRole' . $row->id . '">
                               <div class="modal-dialog modal-dialog-centered">
                                 <div class="modal-content">
                                   <div class="modal-header">
                                     <h4 class="modal-title">' . __('common.delete_item') . '</h4>
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-center">
                                          <h4>' . __('common.are_you_sure_to_delete') . '</h4>
                                        </div>
                                        <div class="mt-40 d-flex justify-content-between">
                                          <a type="button" class="primary-btn tr-bg pt-1" data-dismiss="modal" id="deletePopupClose' . $row->id . '">' . __('common.cancel') . '</a>
                                          <a type="button" class="primary-btn fix-gr-bg roleDeleteClass" href="javascript:void(0);" data-id="' . $row->id . '">' . __('common.delete') . '</a>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                            </div>';
                    return $content;
                })
                ->with('status', 'success')
                ->make(true);
        }
        return abort(404);
    }

    public function roleStore(RoleRequest $request)
    {

        try {

            // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $role = new SmaRole();
            $role->name = strtolower($request->name);
            $role->type = 'User Defined';
            $role->school_id = Auth::user()->school_id;
            $role->save();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function roleEdit(Request $request, $id)
    {
        try {
            // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $role = SmaRole::find($id);
            $roles = SmaRole::where('is_saas', 0)->where('active_status', '=', 1)
                ->where(function ($q) {
                    $q->where('school_id', Auth::user()->school_id)->orWhere('type', 'System');
                })
                ->where('id', '!=', 1)
                ->orderBy('id', 'desc')
                ->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['role'] = $role;
                $data['roles'] = $roles->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('rolepermission::role', compact('role', 'roles'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function roleUpdate(RoleRequest $request)
    {

        try {
            // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $role = SmaRole::find($request->id);
            $role->name = $request->name;
            $result = $role->save();

            Toastr::success('Operation successful', 'Success');
            return redirect()->route('rolepermission/role');
        } catch (\Exception $e) {

            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function schoolBasedRoleDelete(Request $request)
    {
        SmaRole::where('id', $request->id)->where('school_id', Auth::user()->school_id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Successfully Role Deleted.']);
    }

    public function assignPermission($id)
    {
        try {

            // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $role = SmaRole::with('assignedPermission')->where('school_id', Auth::user()->school_id)->where('is_saas', 0)->where('id', $id)->first();
            $already_assigned = $role->assignedPermission->pluck('permission_id')->toArray();


            if ($id == 2) {
                $all_permissions = Permission::with(['subModule' => function ($query) {
                    $query->whereNotIn('route', ['programs.my-student', 'mark-report', 'add-scholarship', 'assign-student', 'add-stipend'])->where('is_student', 1)->where('menu_status', 1)->groupBy('route')->orderBy('position', 'asc');
                }])
                    ->where('school_id', Auth::user()->school_id)
                    ->whereNull('parent_route')
                    ->whereNotNull('route')
                    ->where('menu_status', 1)
                    ->where('is_student', 1)
                    ->whereNotIn('route', ['student_fees', 'menumanage.index', 'library', 'student_transport', 'student_dormitory'])
                    ->whereNotInDeaActiveModulePermission()
                    ->groupBy('route')
                    ->orderBy('position', 'asc')
                    ->get();

                return view('rolepermission::role_permission_student', compact('role', 'all_permissions', 'already_assigned'));
            } else if ($id == 3) {

                $all_permissions = Permission::with(['subModule' => function ($query) {
                    $query->whereNotIn('route', ['add-scholarship', 'assign-student', 'add-stipend'])->where('is_parent', 1)->where('menu_status', 1)->groupBy('route')->orderBy('position', 'asc');
                }])
                    ->where('school_id', Auth::user()->school_id)
                    ->whereNull('parent_route')
                    ->whereNotNull('route')
                    ->where('menu_status', 1)
                    ->where('is_parent', 1)
                    ->whereNotIn('route', ['menumanage.index', 'my_children', 'fees.student-fees-list-parent', 'download-center', 'lesson-plan', 'parent_class_routine', 'parent_homework', 'parent_attendance', 'parent_subjects', 'online_exam', 'parent_transport', 'parent_dormitory_list', 'behaviour_records', 'parent_teacher_list', 'p_library'])
                    ->whereNotInDeaActiveModulePermission()
                    ->groupBy('route')
                    ->orderBy('position', 'asc')
                    ->get();

                return view('rolepermission::role_permission_parent', compact('role', 'all_permissions', 'already_assigned'));
            } else {
                $all_permissions = Permission::with(['subModule' => function ($query) {
                    $query->whereNotIn('route', ['download-center.parent-content-share-list', 'download-center.parent-video-list', 'lesson-student-lessonPlan', 'lesson-student-lessonPlan-overview', 'lesson-parent-lessonPlan', 'lesson-parent-lessonPlan-overview', 'student-pending-leave', 'parent_online_examination', 'student_library'])->where('menu_status', 1)->groupBy('route')->orderBy('position', 'asc');
                }])
                    ->where('school_id', Auth::user()->school_id)
                    ->whereNull('parent_route')
                    ->whereNotNull('route')
                    ->whereNotIn('route', ['menumanage.index', 'student-dashboard', 'parent-dashboard', 'dashboard_section', 'student_fees', 'fees.student-fees-list-parent', 'parent_leave', 'parent_subjects', 'student_subject', 'parent_teacher_list', 'student_teacher', 'parent_transport', 'parent_dormitory_list', 'student_dormitory', 'student-profile', 'my_children', 'wallet.my-wallet', 'parent_class_routine', 'student_homework', 'parent_homework', 'student_section', 'student_class_routine', 'library', 'p_library', 'transport', 'student_transport', 'dormitory'])
                    ->where('menu_status', 1)
                    ->whereNotInDeaActiveModulePermission()
                    ->groupBy('route')
                    ->orderBy('position', 'asc')
                    ->get();

                return view('rolepermission::role_permission', compact('role', 'all_permissions', 'already_assigned'));
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function rolePermissionAssign(Request $request)
    {


        DB::beginTransaction();

        try {
            Schema::disableForeignKeyConstraints();
            // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            AssignPermission::where('school_id', Auth::user()->school_id)->where('role_id', $request->role_id)->delete();

            if ($request->module_id) {

                foreach ($request->module_id as $permission) {

                    $assign = new AssignPermission();
                    $assign->permission_id = $permission;
                    $assign->role_id = $request->role_id;
                    $assign->school_id = Auth::user()->school_id;
                    $assign->save();
                }
            }

            DB::commit();
            // Toastr::success('User must be relogin again for applied permission changes', 'Success');
            Toastr::success('User permission applied successfully', 'Success');
            return redirect('rolepermission/role');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error($e->getMessage(), 'Failed');
            return redirect()->back();
        }
    }
    private function getPermissionList()
    {
        $activeModuleList = SmaModuleInfo::whereNull('parent_route')->where('active_status', 1)->get();
    }
}
