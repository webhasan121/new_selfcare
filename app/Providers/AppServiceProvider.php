<?php

namespace App\Providers;

use App\Models\Connection;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\Setting;
use App\Models\SupportTicket;
use App\Models\UsageReport;
use App\Models\User;
use App\Policies\ConnectionPolicy;
use App\Policies\InvoicePolicy;
use App\Policies\PackagePolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\SettingPolicy;
use App\Policies\SupportTicketPolicy;
use App\Policies\UsageReportPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Connection::class, ConnectionPolicy::class);
        Gate::policy(Invoice::class, InvoicePolicy::class);
        Gate::policy(Package::class, PackagePolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Setting::class, SettingPolicy::class);
        Gate::policy(SupportTicket::class, SupportTicketPolicy::class);
        Gate::policy(UsageReport::class, UsageReportPolicy::class);
        Gate::policy(User::class, UserPolicy::class);

        Gate::before(function (User $user, string $ability) {
            return $user->hasRole('admin')
                ? true
                : null;
        });
    }
}
