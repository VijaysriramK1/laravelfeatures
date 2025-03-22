<?php

namespace App\Http\Middleware;


use Closure;
use App\User;
use App\SmStudent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (User::checkAuth() == false || User::checkAuth() == null) {
            return redirect()->route('system.config');
        }

        session_start();
        $role_id = Session::get('role_id');

        if ($role_id == 2) {
            $check_student = SmStudent::where('user_id', Auth::user()->id)->where('school_id', Auth::user()->school_id)->first();

            if ($check_student->active_status != 2) {
                return $next($request);
            } else {
                if (request()->segment(1) == 'student-profile') {
                    return $next($request);
                } else if (request()->segment(1) == 'student-logout') {
                    return $next($request);
                } else if (request()->segment(1) == 'update-my-profile') {
                    return $next($request);
                } else {
                    return redirect('/no-permission');
                }
            }
        } elseif ($role_id != "") {
            return redirect('admin-dashboard');
        } else {
            return redirect('login');
        }
    }
}
