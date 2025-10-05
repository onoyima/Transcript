<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Staff;

class TranscriptAuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define gates for transcript staff permissions
        Gate::define('view_transcript_applications', function (Staff $staff) {
            return $staff->hasPermission('view_transcript_applications');
        });

        Gate::define('manage_transcript_applications', function (Staff $staff) {
            return $staff->hasPermission('manage_transcript_applications');
        });

        Gate::define('approve_transcript_applications', function (Staff $staff) {
            return $staff->hasPermission('approve_transcript_applications');
        });

        Gate::define('reject_transcript_applications', function (Staff $staff) {
            return $staff->hasPermission('reject_transcript_applications');
        });

        Gate::define('view_transcript_payments', function (Staff $staff) {
            return $staff->hasPermission('view_transcript_payments');
        });

        Gate::define('manage_transcript_payments', function (Staff $staff) {
            return $staff->hasPermission('manage_transcript_payments');
        });

        Gate::define('verify_transcript_payments', function (Staff $staff) {
            return $staff->hasPermission('verify_transcript_payments');
        });

        Gate::define('generate_transcript_reports', function (Staff $staff) {
            return $staff->hasPermission('generate_transcript_reports');
        });

        Gate::define('view_transcript_analytics', function (Staff $staff) {
            return $staff->hasPermission('view_transcript_analytics');
        });

        Gate::define('manage_transcript_staff', function (Staff $staff) {
            return $staff->hasPermission('manage_transcript_staff');
        });

        Gate::define('assign_transcript_roles', function (Staff $staff) {
            return $staff->hasPermission('assign_transcript_roles');
        });

        Gate::define('manage_transcript_system', function (Staff $staff) {
            return $staff->hasPermission('manage_transcript_system');
        });

        Gate::define('view_transcript_audit_logs', function (Staff $staff) {
            return $staff->hasPermission('view_transcript_audit_logs');
        });

        Gate::define('backup_transcript_data', function (Staff $staff) {
            return $staff->hasPermission('backup_transcript_data');
        });

        Gate::define('configure_transcript_settings', function (Staff $staff) {
            return $staff->hasPermission('configure_transcript_settings');
        });
    }
}