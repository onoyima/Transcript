<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Staff;
use App\Models\TranscriptRole;
use App\Models\TranscriptPermission;
use Illuminate\Support\Facades\Gate;

$output = "=== TESTING MIDDLEWARE PROTECTION AND PERMISSIONS ===\n\n";

try {
    // Test different staff members with different roles
    $testStaff = [
        'admin' => Staff::where('email', 'ezimmuo@veritas.edu.ng')->first(), // MARTHA EZIMMUO - has transcript_admin role
        'no_role' => Staff::where('email', 'oforo2@veritas.edu.ng')->first(), // OBUMNEME OFOR - no roles
        'officer' => null // We'll assign this temporarily
    ];
    
    $output .= "1. TESTING STAFF MEMBERS:\n";
    foreach ($testStaff as $type => $staff) {
        if ($staff) {
            $roles = $staff->activeRoles->pluck('display_name')->implode(', ') ?: 'None';
            $output .= "   {$type}: {$staff->fname} {$staff->lname} ({$staff->email}) - Roles: {$roles}\n";
        }
    }
    $output .= "\n";
    
    // Temporarily assign transcript_officer role to test officer permissions
    $officerRole = TranscriptRole::where('name', 'transcript_officer')->first();
    if ($officerRole && $testStaff['no_role']) {
        $testStaff['no_role']->assignRole('transcript_officer', 4);
        $testStaff['officer'] = $testStaff['no_role'];
        $testStaff['officer']->refresh();
        $output .= "   Temporarily assigned 'transcript_officer' role to {$testStaff['officer']->fname} {$testStaff['officer']->lname}\n\n";
    }
    
    // Test permissions for each staff type
    $permissions = [
        'view_transcript_applications',
        'manage_transcript_applications', 
        'process_transcript_requests',
        'view_transcript_payments',
        'manage_transcript_payments',
        'process_transcript_payments',
        'manage_transcript_staff',
        'view_transcript_reports',
        'generate_transcript_reports',
        'manage_transcript_system'
    ];
    
    $output .= "2. PERMISSION TESTING:\n";
    
    foreach ($testStaff as $type => $staff) {
        if (!$staff) continue;
        
        $output .= "\n   {$type} ({$staff->fname} {$staff->lname}):\n";
        
        foreach ($permissions as $permission) {
            $hasPermission = $staff->hasPermission($permission);
            $output .= "     - {$permission}: " . ($hasPermission ? 'ALLOWED' : 'DENIED') . "\n";
        }
    }
    
    // Test role-based access
    $output .= "\n3. ROLE-BASED ACCESS TESTING:\n";
    
    $roleTests = [
        'transcript_officer' => ['admin', 'officer'],
        'payment_officer' => ['admin'],
        'transcript_admin' => ['admin'],
        'transcript_supervisor' => ['admin']
    ];
    
    foreach ($roleTests as $requiredRole => $expectedAccess) {
        $output .= "\n   Required Role: {$requiredRole}\n";
        
        foreach ($testStaff as $type => $staff) {
            if (!$staff) continue;
            
            $hasRole = $staff->hasRole($requiredRole);
            $shouldHaveAccess = in_array($type, $expectedAccess);
            $status = $hasRole ? 'ALLOWED' : 'DENIED';
            $expected = $shouldHaveAccess ? 'EXPECTED' : 'EXPECTED';
            
            $output .= "     {$type}: {$status} ({$expected})\n";
        }
    }
    
    // Test Gate permissions (Laravel's authorization gates)
    $output .= "\n4. GATE AUTHORIZATION TESTING:\n";
    
    $gates = [
        'manage_transcript_staff',
        'view_transcript_applications',
        'manage_transcript_applications',
        'process_transcript_requests'
    ];
    
    foreach ($testStaff as $type => $staff) {
        if (!$staff) continue;
        
        $output .= "\n   {$type} ({$staff->fname} {$staff->lname}):\n";
        
        // Set the authenticated user for gate testing
        auth('transcript_staff')->login($staff);
        
        foreach ($gates as $gate) {
            try {
                $allowed = Gate::allows($gate);
                $output .= "     - Gate '{$gate}': " . ($allowed ? 'ALLOWED' : 'DENIED') . "\n";
            } catch (Exception $e) {
                $output .= "     - Gate '{$gate}': ERROR - {$e->getMessage()}\n";
            }
        }
        
        auth('transcript_staff')->logout();
    }
    
    // Test middleware simulation
    $output .= "\n5. MIDDLEWARE SIMULATION:\n";
    
    $protectedRoutes = [
        '/transcript/staff/management' => ['manage_transcript_staff'],
        '/transcript/staff/applications' => ['view_transcript_applications'],
        '/transcript/staff/payments' => ['view_transcript_payments'],
        '/transcript/staff/reports' => ['view_transcript_reports']
    ];
    
    foreach ($testStaff as $type => $staff) {
        if (!$staff) continue;
        
        $output .= "\n   {$type} Access Simulation:\n";
        
        foreach ($protectedRoutes as $route => $requiredPermissions) {
            $hasAccess = false;
            
            foreach ($requiredPermissions as $permission) {
                if ($staff->hasPermission($permission)) {
                    $hasAccess = true;
                    break;
                }
            }
            
            $status = $hasAccess ? 'ALLOWED' : 'DENIED';
            $requiredPermsStr = implode(' OR ', $requiredPermissions);
            $output .= "     {$route} (requires: {$requiredPermsStr}): {$status}\n";
        }
    }
    
    // Clean up - remove the temporarily assigned role
    if ($testStaff['officer']) {
        $testStaff['officer']->removeRole('transcript_officer');
        $output .= "\n   Cleaned up: Removed temporary 'transcript_officer' role from {$testStaff['officer']->fname} {$testStaff['officer']->lname}\n";
    }
    
    $output .= "\n=== MIDDLEWARE AND PERMISSION TESTING COMPLETED ===\n";
    
} catch (Exception $e) {
    $output .= "\nERROR: " . $e->getMessage() . "\n";
    $output .= "Stack trace: " . $e->getTraceAsString() . "\n";
}

// Write output to file
file_put_contents('test_middleware_output.txt', $output);
echo $output;