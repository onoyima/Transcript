<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Staff;
use App\Models\TranscriptRole;
use App\Models\TranscriptPermission;

$output = "=== TESTING DATABASE DATA ===\n\n";
file_put_contents('test_output.txt', $output);

// Test 1: Check existing roles
$output .= "1. EXISTING TRANSCRIPT ROLES:\n";
$output .= "-----------------------------\n";
try {
    $roles = TranscriptRole::all();
    if ($roles->count() > 0) {
        foreach ($roles as $role) {
            $output .= "ID: {$role->id} | Name: {$role->name} | Display: {$role->display_name} | Active: " . ($role->is_active ? 'Yes' : 'No') . "\n";
        }
    } else {
        $output .= "No roles found in database.\n";
    }
} catch (Exception $e) {
    $output .= "Error checking roles: " . $e->getMessage() . "\n";
}
$output .= "\n";

// Test 2: Check existing permissions
$output .= "2. EXISTING TRANSCRIPT PERMISSIONS:\n";
$output .= "-----------------------------------\n";
try {
    $permissions = TranscriptPermission::all();
    if ($permissions->count() > 0) {
        foreach ($permissions as $permission) {
            $output .= "ID: {$permission->id} | Name: {$permission->name} | Display: {$permission->display_name} | Module: {$permission->module} | Active: " . ($permission->is_active ? 'Yes' : 'No') . "\n";
        }
    } else {
        $output .= "No permissions found in database.\n";
    }
} catch (Exception $e) {
    $output .= "Error checking permissions: " . $e->getMessage() . "\n";
}
$output .= "\n";

// Test 3: Check existing staff
$output .= "3. EXISTING STAFF MEMBERS:\n";
$output .= "--------------------------\n";
try {
    $staff = Staff::all();
    if ($staff->count() > 0) {
        foreach ($staff as $member) {
            $output .= "ID: {$member->id} | Name: {$member->fname} {$member->lname} | Email: {$member->email}\n";
            
            // Check staff roles
            try {
                $staffRoles = $member->activeRoles;
                if ($staffRoles->count() > 0) {
                    $output .= "  Roles: ";
                    foreach ($staffRoles as $role) {
                        $output .= "{$role->display_name} ";
                    }
                    $output .= "\n";
                } else {
                    $output .= "  Roles: None assigned\n";
                }
            } catch (Exception $e) {
                $output .= "  Roles: Error - " . $e->getMessage() . "\n";
            }
            $output .= "\n";
        }
    } else {
        $output .= "No staff found in database.\n";
    }
} catch (Exception $e) {
    $output .= "Error checking staff: " . $e->getMessage() . "\n";
}

// Test 4: Test specific staff permissions
$output .= "4. TESTING STAFF PERMISSIONS:\n";
$output .= "-----------------------------\n";
try {
    $firstStaff = Staff::first();
    if ($firstStaff) {
        $output .= "Testing permissions for: {$firstStaff->fname} {$firstStaff->lname}\n";
        
        $testPermissions = [
            'view_transcript_applications',
            'manage_transcript_applications', 
            'manage_transcript_staff',
            'manage_transcript_payments'
        ];
        
        foreach ($testPermissions as $permission) {
            try {
                $hasPermission = $firstStaff->hasPermission($permission);
                $output .= "  - {$permission}: " . ($hasPermission ? 'YES' : 'NO') . "\n";
            } catch (Exception $e) {
                $output .= "  - {$permission}: ERROR - " . $e->getMessage() . "\n";
            }
        }
    } else {
        $output .= "No staff found to test permissions.\n";
    }
} catch (Exception $e) {
    $output .= "Error testing permissions: " . $e->getMessage() . "\n";
}

$output .= "\n=== TEST COMPLETED ===\n";

// Write all output to file
file_put_contents('test_output.txt', $output);
echo "Test completed. Check test_output.txt for results.\n";