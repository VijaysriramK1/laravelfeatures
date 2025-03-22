<?php

namespace App\Providers;


use App\SmStudent;
use App\Observers\SmStudentObserver;
use App\SmAdmissionQuery;
use App\Observers\SmAdmissionQueryObserver;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];


    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerObservers();

        // if (! $this->app->routesAreCached()) {
        //     Passport::routes();
        // }
        // Passport::routes();
        // Passport::tokensExpireIn(now()->addDays(30));
        // Passport::refreshTokensExpireIn(now()->addDays(30));
        // Passport::personalAccessTokensExpireIn(now()->addDays(30));
    }

    protected function registerObservers(): void
    {
        SmStudent::observe(SmStudentObserver::class);
        SmAdmissionQuery::observe(SmAdmissionQueryObserver::class);
    }
}
