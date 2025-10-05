<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TranscriptRole;
use App\Models\TranscriptPermission;

class TranscriptRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        $permissions = [
            // Transcript permissions
            [
                'name' => 'view_transcript_applications',
                'display_name' => 'View Transcript Applications',
                'description' => 'Can view all transcript applications',
                'module' => 'transcript'
            ],
            [
                'name' => 'manage_transcript_applications',
                'display_name' => 'Manage Transcript Applications',
                'description' => 'Can approve, reject, and update transcript applications',
                'module' => 'transcript'
            ],
            [
                'name' => 'process_transcript_requests',
                'display_name' => 'Process Transcript Requests',
                'description' => 'Can process and fulfill transcript requests',
                'module' => 'transcript'
            ],
            [
                'name' => 'generate_transcript_reports',
                'display_name' => 'Generate Transcript Reports',
                'description' => 'Can generate reports related to transcript applications',
                'module' => 'transcript'
            ],

            // Payment permissions
            [
                'name' => 'view_transcript_payments',
                'display_name' => 'View Transcript Payments',
                'description' => 'Can view all transcript payment records',
                'module' => 'payment'
            ],
            [
                'name' => 'manage_transcript_payments',
                'display_name' => 'Manage Transcript Payments',
                'description' => 'Can verify, approve, and manage transcript payments',
                'module' => 'payment'
            ],
            [
                'name' => 'process_transcript_refunds',
                'display_name' => 'Process Transcript Refunds',
                'description' => 'Can process refunds for transcript payments',
                'module' => 'payment'
            ],
            [
                'name' => 'generate_payment_reports',
                'display_name' => 'Generate Payment Reports',
                'description' => 'Can generate financial reports for transcript payments',
                'module' => 'payment'
            ],

            // Admin permissions
            [
                'name' => 'manage_transcript_staff',
                'display_name' => 'Manage Transcript Staff',
                'description' => 'Can manage staff members and their roles in transcript system',
                'module' => 'admin'
            ],
            [
                'name' => 'manage_transcript_system',
                'display_name' => 'Manage Transcript System',
                'description' => 'Can configure and manage the transcript system settings',
                'module' => 'admin'
            ],
            [
                'name' => 'view_transcript_analytics',
                'display_name' => 'View Transcript Analytics',
                'description' => 'Can view system analytics and performance metrics',
                'module' => 'admin'
            ],
            [
                'name' => 'manage_transcript_security',
                'display_name' => 'Manage Transcript Security',
                'description' => 'Can manage security settings and audit logs',
                'module' => 'admin'
            ],
        ];

        foreach ($permissions as $permission) {
            TranscriptPermission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        // Create Roles
        $roles = [
            [
                'name' => 'transcript_officer',
                'display_name' => 'Transcript Officer',
                'description' => 'Staff member responsible for processing transcript applications',
                'permissions' => [
                    'view_transcript_applications',
                    'manage_transcript_applications',
                    'process_transcript_requests',
                    'view_transcript_payments'
                ]
            ],
            [
                'name' => 'payment_officer',
                'display_name' => 'Payment Officer',
                'description' => 'Staff member responsible for managing transcript payments',
                'permissions' => [
                    'view_transcript_payments',
                    'manage_transcript_payments',
                    'process_transcript_refunds',
                    'view_transcript_applications'
                ]
            ],
            [
                'name' => 'transcript_admin',
                'display_name' => 'Transcript Administrator',
                'description' => 'Administrator with full access to transcript system',
                'permissions' => [
                    'view_transcript_applications',
                    'manage_transcript_applications',
                    'process_transcript_requests',
                    'generate_transcript_reports',
                    'view_transcript_payments',
                    'manage_transcript_payments',
                    'process_transcript_refunds',
                    'generate_payment_reports',
                    'manage_transcript_staff',
                    'manage_transcript_system',
                    'view_transcript_analytics',
                    'manage_transcript_security'
                ]
            ],
            [
                'name' => 'transcript_supervisor',
                'display_name' => 'Transcript Supervisor',
                'description' => 'Supervisor with oversight of transcript operations',
                'permissions' => [
                    'view_transcript_applications',
                    'manage_transcript_applications',
                    'process_transcript_requests',
                    'generate_transcript_reports',
                    'view_transcript_payments',
                    'manage_transcript_payments',
                    'generate_payment_reports',
                    'view_transcript_analytics'
                ]
            ]
        ];

        foreach ($roles as $roleData) {
            $permissions = $roleData['permissions'];
            unset($roleData['permissions']);

            $role = TranscriptRole::firstOrCreate(
                ['name' => $roleData['name']],
                $roleData
            );

            // Assign permissions to role
            $permissionModels = TranscriptPermission::whereIn('name', $permissions)->get();
            $role->permissions()->sync($permissionModels->pluck('id'));
        }
    }
}