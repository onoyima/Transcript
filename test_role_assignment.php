<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Staff;
use App\Models\TranscriptRole;
use App\Models\TranscriptPermission;

$output = "=== TESTING ROLE ASSIGNMENT FUNCTIONALITY ===\n\n";

try {
    // Find a staff member without roles (from our previous test, we know OBUMNEME OFOR has no roles)
    $staff = Staff::where('email', 'oforo2@veritas.edu.ng')->first();
    
    if (!$staff) {
        $output .= "ERROR: Staff member not found!\n";
        file_put_contents('test_role_assignment_output.txt', $output);
        exit(1);
    }
    
    $output .= "1. TESTING STAFF MEMBER:\n";
    $output .= "   Name: {$staff->fname} {$staff->lname}\n";
    $output .= "   Email: {$staff->email}\n";
    $output .= "   Current Roles: " . ($staff->activeRoles->count() > 0 ? $staff->activeRoles->pluck('display_name')->implode(', ') : 'None') . "\n\n";
    
    // Get available roles
    $roles = TranscriptRole::where('is_active', true)->get();
    $output .= "2. AVAILABLE ROLES:\n";
    foreach ($roles as $role) {
        $output .= "   - {$role->display_name} ({$role->name})\n";
    }
    $output .= "\n";
    
    // Assign transcript_officer role
    $transcriptOfficerRole = TranscriptRole::where('name', 'transcript_officer')->first();
    
    if (!$transcriptOfficerRole) {
        $output .= "ERROR: transcript_officer role not found!\n";
        file_put_contents('test_role_assignment_output.txt', $output);
        exit(1);
    }
    
    $output .= "3. ASSIGNING ROLE:\n";
    $output .= "   Assigning '{$transcriptOfficerRole->display_name}' role to {$staff->fname} {$staff->lname}...\n";
    
    // Check if staff already has this role
    if ($staff->hasRole($transcriptOfficerRole->name)) {
        $output .= "   Staff member already has this role!\n";
    } else {
        // Assign the role (using admin staff ID 4 - MARTHA EZIMMUO)
        $staff->assignRole($transcriptOfficerRole->name, 4);
        $output .= "   Role assigned successfully!\n";
    }
    
    // Refresh the staff model to get updated roles
    $staff->refresh();
    
    $output .= "\n4. VERIFICATION AFTER ASSIGNMENT:\n";
    $output .= "   Current Roles: " . ($staff->activeRoles->count() > 0 ? $staff->activeRoles->pluck('display_name')->implode(', ') : 'None') . "\n";
    
    // Test role checking methods
    $output .= "\n5. TESTING ROLE CHECKING METHODS:\n";
    $output .= "   hasRole('transcript_officer'): " . ($staff->hasRole('transcript_officer') ? 'YES' : 'NO') . "\n";
    $output .= "   hasAnyRole(['transcript_officer', 'payment_officer']): " . ($staff->hasAnyRole(['transcript_officer', 'payment_officer']) ? 'YES' : 'NO') . "\n";
    
    // Test permission checking
    $output .= "\n6. TESTING PERMISSION CHECKING:\n";
    $permissions = ['view_transcript_applications', 'manage_transcript_applications', 'process_transcript_requests', 'view_transcript_payments'];
    
    foreach ($permissions as $permission) {
        $hasPermission = $staff->hasPermission($permission);
        $output .= "   hasPermission('{$permission}'): " . ($hasPermission ? 'YES' : 'NO') . "\n";
    }
    
    // Get all permissions for this staff member
    $allPermissions = $staff->getAllPermissions();
    $output .= "\n7. ALL PERMISSIONS FOR THIS STAFF MEMBER:\n";
    if ($allPermissions->count() > 0) {
        foreach ($allPermissions as $permission) {
            $output .= "   - {$permission->display_name} ({$permission->name}) - Module: {$permission->module}\n";
        }
    } else {
        $output .= "   No permissions found.\n";
    }
    
    // Test role removal
    $output .= "\n8. TESTING ROLE REMOVAL:\n";
    $output .= "   Removing '{$transcriptOfficerRole->display_name}' role from {$staff->fname} {$staff->lname}...\n";
    
    $staff->removeRole($transcriptOfficerRole->name);
    $staff->refresh();
    
    $output .= "   Role removed successfully!\n";
    $output .= "   Current Roles After Removal: " . ($staff->activeRoles->count() > 0 ? $staff->activeRoles->pluck('display_name')->implode(', ') : 'None') . "\n";
    
    $output .= "\n=== ROLE ASSIGNMENT TEST COMPLETED SUCCESSFULLY ===\n";
    
} catch (Exception $e) {
    $output .= "\nERROR: " . $e->getMessage() . "\n";
    $output .= "Stack trace: " . $e->getTraceAsString() . "\n";
}

// Write output to file
file_put_contents('test_role_assignment_output.txt', $output);
echo $output;