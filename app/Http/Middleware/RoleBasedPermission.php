<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\RolePermission\Entities\Permission;
use Modules\RolePermission\Entities\AssignPermission;
use Symfony\Component\HttpFoundation\Response;

class RoleBasedPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    protected $logined_user_id;
    protected $logined_role_id;
    protected $logined_school_id;
    public function handle(Request $request, Closure $next): Response
    {
        if (request()->segment(1) == 'no-permission-access') {
            return $next($request);
        }

        if (request()->segment(1) == '') {
            return $next($request);
        }

        if (Auth::check() && !empty(Auth::id())) {
            $this->logined_user_id = Auth::id();
            $this->logined_role_id = Auth::user()->role_id;
            $this->logined_school_id = Auth::user()->school_id;

            if ($this->logined_role_id != 1 && $this->logined_role_id != 5) {
                $check_role_based_module_permission = AssignPermission::where('role_id', $this->logined_role_id)->where('school_id', $this->logined_school_id)->get();
                $check_count = $check_role_based_module_permission->count();

                if ($check_count > 0) {
                    foreach ($check_role_based_module_permission as $get_permission) {
                        $permission_details[] = $get_permission->permission_id;
                    }

                    $get_authorized_modules_details = Permission::whereIn('id', $permission_details)->where('school_id', $this->logined_school_id)->get();
                    $get_unauthorized_modules_details = Permission::whereNotIn('id', $permission_details)->where('school_id', $this->logined_school_id)->get();

                    foreach ($get_authorized_modules_details as $authorized_value) {
                        $authorized_routes[] = $authorized_value->route;
                    }

                    foreach ($get_unauthorized_modules_details as $unauthorized_value) {
                        $unauthorized_routes[] = $unauthorized_value->route;
                    }

                    if (Route::currentRouteName() != '') {
                        if (in_array(Route::currentRouteName(), $authorized_routes)) {
                            return $next($request);
                        } else if (in_array(Route::currentRouteName(), $unauthorized_routes)) {
                            return redirect('/no-permission-access');
                        } else {
                            return $next($request);
                        }
                    } else {
                        return $next($request);
                    }
                } else {
                    if (Route::currentRouteName() != '') {
                        Auth::logout();
                        return redirect('/');
                    } else {
                        return redirect('/no-permission-access');
                    }
                }
            } else {
                return $next($request);
            }
        } else {
            $get_permission_modules = Permission::get();

            foreach ($get_permission_modules as $permission_modules) {
                $get_all_permissions_routes[] = $permission_modules->route;
            }

            if (Route::currentRouteName() != '') {
                if (in_array(Route::currentRouteName(), $get_all_permissions_routes)) {
                    return redirect('/no-permission-access');
                } else {
                    return $next($request);
                }
            } else {
                return $next($request);
            }
        }
    }
}
