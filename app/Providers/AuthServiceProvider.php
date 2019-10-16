<?php

namespace App\Providers;

use Storage;
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
        'App\Partner' => 'App\Policies\PartnerPolicy',
        'App\Center' => 'App\Policies\CenterPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('partner-profile-verified', 'App\Policies\PartnerPolicy@PartnerProfileVerified');
        Gate::define('partner-has-jobrole', 'App\Policies\PartnerPolicy@PartnerHasJobRole');
        Gate::define('partner-center-profile-active-verified', 'App\Policies\PartnerPolicy@CenterProfileVerifiedAndActive');
        Gate::define('partner-has-access-to-file', 'App\Policies\PartnerPolicy@PartnerHasAccessToFile');
        Gate::define('center-profile-active-verified', 'App\Policies\CenterPolicy@CenterProfileVerifiedAndActive');

    }
}
