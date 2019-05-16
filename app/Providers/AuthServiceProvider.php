<?php

namespace App\Providers;

use App\Models\Lead;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        Passport::routes();

        $this->registerPolicies();

        Gate::define('show-own-leads', function ($user) {
            return $user->hasAccess(['show-own-leads']);
        });
        Gate::define('show-all-leads', function ($user) {
            return $user->hasAccess(['show-all-leads']);
        });
        Gate::define('add-lead', function ($user) {
            return $user->hasAccess(['add-lead']);
        });
        Gate::define('lead', function ($user) {
            return $user->hasAccess(['lead']);
        });
        Gate::define('admin', function ($user) {
            return $user->hasAccess(['admin']);
        });
        Gate::define('invite-user', function ($user) {
            return $user->hasAccess(['invite-user']);
        });
        Gate::define('add-own-lead-image', function ($user, $lead_id) {
            return Lead::find($lead_id)->user_id == $user->id;
        });
        Gate::define('destroy-own-lead-image', function ($user, $img) {
            return $img->lead->user_id == $user->id;
        });
        Gate::define('update-status', function ($user) {
            return $user->hasAccess(['update-status']);
        });
        Gate::define('manager', function ($user) {
            return $user->hasAccess(['manager']);
        });
        Gate::define('show-all-statistic', function ($user) {
            return $user->hasAccess(['show-all-statistic']);
        });
        Gate::define('change-role', function ($user) {
            return $user->hasAccess(['change-role']);
        });
        Gate::define('banned', function ($user) {
            return $user->hasAccess(['banned']);
        });
        Gate::define('update-lead-phone', function ($user) {
            return $user->hasAccess(['update-lead-phone']);
        });
        Gate::define('take-on-check', function ($user) {
            return $user->hasAccess(['take-on-check']);
        });
        Gate::define('feedback', function ($user) {
            return $user->hasAccess(['feedback']);
        });
        Gate::define('underwriter', function ($user) {
            return $user->hasAccess(['underwriter']);
        });
        Gate::define('telegram', function ($user) {
            return $user->hasAccess(['telegram']);
        });
        Gate::define('notification', function ($user) {
            return $user->hasAccess(['notification']);
        });
        Gate::define('email', function ($user) {
            return $user->hasAccess(['email']);
        });
        Gate::define('reports', function ($user) {
            return $user->hasAccess(['reports']);
        });
        Gate::define('api', function ($user) {
            return $user->hasAccess(['api']);
        });

    }
}
