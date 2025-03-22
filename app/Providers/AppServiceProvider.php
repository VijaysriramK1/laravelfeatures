<?php

namespace App\Providers;

use App\SmParent;
use App\Models\Plugin;
use App\SmNotification;
use App\SmGeneralSettings;
use App\Models\CustomMixin;
use Spatie\Valuestore\Valuestore;
use App\Models\MaintenanceSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Modules\MenuManage\Entities\Sidebar;
use Modules\MenuManage\Entities\SidebarNew;
use Modules\RolePermission\Entities\SmaRole;
use Modules\RolePermission\Entities\Permission;
use Modules\RolePermission\Entities\SmaModuleInfo;
use Modules\RolePermission\Entities\AssignPermission;
use Modules\RolePermission\Entities\SmaPermissionAssign;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {

        try {
            Paginator::useBootstrapFour();
            Builder::defaultStringLength(191);

            view()->composer('backEnd.partials.parents_sidebar', function ($view) {
                $data = [
                    'childrens' => SmParent::myChildrens(),
                ];
                $view->with($data);
            });


            view()->composer('backEnd.partials.menu', function ($view) {
                $notifications = DB::table('notifications')->where('notifiable_id', auth()->id())
                    ->where('read_at', null)
                    ->get();

                foreach ($notifications as $notification) {
                    $notification->data = json_decode($notification->data);
                }

                $view->with(['notifications_for_chat' => $notifications]);
            });

            view()->composer(['backEnd.master', 'backEnd.partials.menu'], function ($view) {
                $data = [
                    'notifications' => SmNotification::notifications(),
                ];
                $view->with($data);
            });


            view()->composer(['plugins.tawk_to'], function ($view) {
                $data = [
                    'agent' => new \Jenssegers\Agent\Agent(),
                    'tawk_setting' => Plugin::where('name', 'tawk')->where('school_id', app('school')->id)->first()
                ];
                $view->with($data);
            });

            view()->composer(['backEnd.partials.menu'], function ($view) {
                $data = [
                    'position' => Plugin::where('name', 'tawk')->where('school_id', app('school')->id)->first()->position,
                    'messenger_position' =>  Plugin::where('name', 'messenger')->where('school_id', app('school')->id)->first()->position,
                ];
                $view->with($data);
            });

            view()->composer(['plugins.messenger'], function ($view) {
                $data = [
                    'agent' => new \Jenssegers\Agent\Agent(),
                    'messenger_setting' => Plugin::where('name', 'messenger')->where('school_id', app('school')->id)->first()
                ];
                $view->with($data);
            });

            view()->composer(['layouts.pb-site'], function ($view) {
                $data = [
                    'position' => Plugin::where('name', 'tawk')->where('school_id', app('school')->id)->first()->position,
                    'messenger_position' =>  Plugin::where('name', 'messenger')->where('school_id', app('school')->id)->first()->position,
                ];
                $view->with($data);
            });

            view()->composer(['frontEnd.home.front_master'], function ($view) {
                $data = [
                    'position' => Plugin::where('name', 'tawk')->where('school_id', app('school')->id)->first()->position,
                    'messenger_position' =>  Plugin::where('name', 'messenger')->where('school_id', app('school')->id)->first()->position,
                ];
                $view->with($data);
            });

            config(['broadcasting.default' => saasEnv('chatting_method')]);
            config(['broadcasting.connections.pusher.key' => saasEnv('pusher_app_key')]);
            config(['broadcasting.connections.pusher.secret' => saasEnv('pusher_app_secret')]);
            config(['broadcasting.connections.pusher.app_id' => saasEnv('pusher_app_id')]);
            config(['broadcasting.connections.pusher.options.cluster' => saasEnv('pusher_app_cluster')]);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->singleton('dashboard_bg', function () {
            $dashboard_background = DB::table('sm_background_settings')->where('school_id', app('school')->id)->where([['is_default', 1], ['title', 'Dashboard Background']])->first();
            return $dashboard_background;
        });

        $this->app->singleton('school_info', function () {
            return SmGeneralSettings::where('school_id', app('school')->id)->first();
        });

        $this->app->singleton('school_menu_permissions', function () {
            $module_ids = getPlanPermissionMenuModuleId();
            return SmaModuleInfo::where('parent_id', 0)->with(['children'])->whereIn('id', $module_ids)->get();
        });

        $this->app->singleton('permission', function () {

            $SmaRole = SmaRole::find(Auth::user()->role_id);
            $permissionIds = AssignPermission::where('role_id', Auth::user()->role_id)
                ->when($SmaRole->is_saas == 0, function ($q) {
                    $q->where('school_id', Auth::user()->school_id);
                })->pluck('permission_id')->toArray();

            $permissions = Permission::whereIn('id', $permissionIds)->pluck('route')->toArray();
        });

        $this->app->singleton('saasSettings', function () {
            return \Modules\Saas\Entities\SaasSettings::where('saas_status', 0)->pluck('sma_module_id')->toArray();
        });


        $this->app->singleton('sidebar_news', function () {
            return  Sidebar::get();
        });

        // app()->instance('school', SaasSchool());
    }
}
