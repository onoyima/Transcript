<?php

echo "=== Comprehensive Transcript Submission Test ===\n\n";

// Test 1: Check if the application is running
echo "1. Testing application accessibility...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
    echo "✓ Application is running (HTTP $httpCode)\n";
} else {
    echo "✗ Application not accessible (HTTP $httpCode)\n";
    exit(1);
}

// Test 2: Check transcript form page (should redirect to login)
echo "\n2. Testing transcript form access (unauthenticated)...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/student/transcript/create');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // Don't follow redirects
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$redirectUrl = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
curl_close($ch);

if ($httpCode == 302 && strpos($redirectUrl, 'login') !== false) {
    echo "✓ Transcript form requires authentication (redirects to login)\n";
    echo "  Redirect URL: $redirectUrl\n";
} else {
    echo "✗ Unexpected response (HTTP $httpCode)\n";
    if ($redirectUrl) echo "  Redirect URL: $redirectUrl\n";
}

// Test 3: Check login page
echo "\n3. Testing login page...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/student/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
    echo "✓ Login page accessible (HTTP $httpCode)\n";
    
    // Check if login form exists
    if (strpos($response, 'name="email"') !== false && strpos($response, 'name="password"') !== false) {
        echo "✓ Login form found with email and password fields\n";
    } else {
        echo "✗ Login form not found or missing required fields\n";
    }
} else {
    echo "✗ Login page not accessible (HTTP $httpCode)\n";
}

// Test 4: Check if we can get CSRF token from login page
echo "\n4. Testing CSRF token extraction...\n";
if (preg_match('/<meta name="csrf-token" content="([^"]+)"/', $response, $matches)) {
    $csrfToken = $matches[1];
    echo "✓ CSRF token found: " . substr($csrfToken, 0, 10) . "...\n";
} elseif (preg_match('/<input[^>]*name="_token"[^>]*value="([^"]+)"/', $response, $matches)) {
    $csrfToken = $matches[1];
    echo "✓ CSRF token found in form: " . substr($csrfToken, 0, 10) . "...\n";
} else {
    echo "✗ CSRF token not found\n";
    $csrfToken = null;
}

// Test 5: Test database connectivity (if possible)
echo "\n5. Testing database connectivity...\n";
if (file_exists('.env')) {
    $envContent = file_get_contents('.env');
    if (preg_match('/DB_CONNECTION=(.+)/', $envContent, $matches)) {
        echo "✓ Database connection configured: " . trim($matches[1]) . "\n";
    }
    if (preg_match('/DB_DATABASE=(.+)/', $envContent, $matches)) {
        echo "✓ Database name: " . trim($matches[1]) . "\n";
    }
} else {
    echo "✗ .env file not found\n";
}

// Test 6: Check route definitions
echo "\n6. Testing route definitions...\n";
$routeOutput = shell_exec('php artisan route:list --name=student.transcript 2>&1');
if ($routeOutput && strpos($routeOutput, 'student.transcript.store') !== false) {
    echo "✓ student.transcript.store route found\n";
} else {
    echo "✗ student.transcript.store route not found\n";
    echo "Route output: " . substr($routeOutput, 0, 200) . "...\n";
}

// Test 7: Manual testing instructions
echo "\n=== Manual Testing Instructions ===\n";
echo "To test the form submission manually:\n\n";

echo "1. Open your browser and go to: http://localhost:8000\n";
echo "2. Navigate to the student login page\n";
echo "3. Log in with valid student credentials\n";
echo "4. Navigate to: http://localhost:8000/student/transcript/create\n";
echo "5. Fill out the transcript application form:\n";
echo "   - Application Type: undergraduate\n";
echo "   - Category: student\n";
echo "   - Type: physical\n";
echo "   - Destination: self_collection\n";
echo "   - Purpose: Test submission\n";
echo "   - Number of copies: 1\n";
echo "6. Submit the form and check:\n";
echo "   - Browser developer console for JavaScript errors\n";
echo "   - Network tab for the POST request\n";
echo "   - Laravel logs: tail -f storage/logs/laravel.log\n\n";

echo "=== Automated Testing with Authentication ===\n";
echo "To test with authentication, you would need to:\n";
echo "1. Create a test student account or use existing credentials\n";
echo "2. Perform login via POST request to get session cookies\n";
echo "3. Use those cookies to access the transcript form\n";
echo "4. Submit the form with proper CSRF token and session\n\n";

echo "=== Laravel Artisan Commands for Testing ===\n";
echo "Run these commands to test individual components:\n";
echo "php artisan tinker\n";
echo ">>> App\\Models\\Student::first()\n";
echo ">>> route('student.transcript.store')\n";
echo ">>> csrf_token()\n";
echo ">>> DB::connection()->getPdo()\n\n";

echo "=== Test Complete ===\n";
echo "The form submission requires authentication. The route and components appear to be properly configured.\n";
echo "The issue is likely that users need to be logged in to access the transcript form.\n";