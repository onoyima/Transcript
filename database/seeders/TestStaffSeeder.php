<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Staff;
use App\Models\TranscriptRole;

class TestStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test staff members
        $testStaff = [
            [
                'first_name' => 'John',
                'last_name' => 'Admin',
                'email' => 'admin@transcript.test',
                'password' => Hash::make('password123'),
                'phone' => '08012345678',
                'department' => 'Administration',
                'position' => 'System Administrator',
                'is_active' => true,
                'role' => 'transcript_admin'
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Officer',
                'email' => 'officer@transcript.test',
                'password' => Hash::make('password123'),
                'phone' => '08012345679',
                'department' => 'Academic Affairs',
                'position' => 'Transcript Officer',
                'is_active' => true,
                'role' => 'transcript_officer'
            ],
            [
                'first_name' => 'Mike',
                'last_name' => 'Payment',
                'email' => 'payment@transcript.test',
                'password' => Hash::make('password123'),
                'phone' => '08012345680',
                'department' => 'Finance',
                'position' => 'Payment Officer',
                'is_active' => true,
                'role' => 'payment_officer'
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Supervisor',
                'email' => 'supervisor@transcript.test',
                'password' => Hash::make('password123'),
                'phone' => '08012345681',
                'department' => 'Academic Affairs',
                'position' => 'Transcript Supervisor',
                'is_active' => true,
                'role' => 'transcript_supervisor'
            ]
        ];

        foreach ($testStaff as $staffData) {
            $roleName = $staffData['role'];
            unset($staffData['role']);

            // Create staff member
            $staff = Staff::firstOrCreate(
                ['email' => $staffData['email']],
                $staffData
            );

            // Assign role
            $role = TranscriptRole::where('name', $roleName)->first();
            if ($role && !$staff->hasRole($roleName)) {
                $staff->assignRole($role);
            }

            $this->command->info("Created staff: {$staff->full_name} ({$staff->email}) with role: {$roleName}");
        }
    }
}