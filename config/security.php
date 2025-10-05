<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Student Verification Security Settings
    |--------------------------------------------------------------------------
    |
    | These settings control the security measures for student verification
    | and transcript application processes.
    |
    */

    'verification' => [
        // Rate limiting for verification attempts
        'max_attempts' => env('VERIFICATION_MAX_ATTEMPTS', 5),
        'rate_limit_window' => env('VERIFICATION_RATE_LIMIT_WINDOW', 15), // minutes
        
        // Session security
        'session_timeout' => env('VERIFICATION_SESSION_TIMEOUT', 30), // minutes
        'enforce_ip_consistency' => env('VERIFICATION_ENFORCE_IP', true),
        'enforce_user_agent_consistency' => env('VERIFICATION_ENFORCE_USER_AGENT', true),
        
        // Request frequency limits
        'max_requests_per_window' => env('VERIFICATION_MAX_REQUESTS', 10),
        'request_window' => env('VERIFICATION_REQUEST_WINDOW', 5), // minutes
    ],

    'payment' => [
        // Payment processing limits
        'max_payment_attempts' => env('PAYMENT_MAX_ATTEMPTS', 3),
        'payment_rate_limit_window' => env('PAYMENT_RATE_LIMIT_WINDOW', 60), // minutes
        
        // Payment security
        'require_fresh_session' => env('PAYMENT_REQUIRE_FRESH_SESSION', true),
        'max_session_age_for_payment' => env('PAYMENT_MAX_SESSION_AGE', 20), // minutes
    ],

    'audit' => [
        // Audit logging settings
        'log_all_attempts' => env('AUDIT_LOG_ALL_ATTEMPTS', true),
        'log_successful_verifications' => env('AUDIT_LOG_SUCCESSFUL', true),
        'log_suspicious_activities' => env('AUDIT_LOG_SUSPICIOUS', true),
        'log_session_events' => env('AUDIT_LOG_SESSIONS', true),
        
        // Log retention
        'log_retention_days' => env('AUDIT_LOG_RETENTION_DAYS', 90),
    ],

    'application' => [
        // Duplicate application prevention
        'prevent_duplicate_applications' => env('PREVENT_DUPLICATE_APPLICATIONS', true),
        'allowed_application_statuses_for_new' => ['Rejected', 'Cancelled'],
        
        // Application limits
        'max_applications_per_student' => env('MAX_APPLICATIONS_PER_STUDENT', 1),
        'application_cooldown_period' => env('APPLICATION_COOLDOWN_PERIOD', 24), // hours
    ],

    'security_headers' => [
        // Security headers to be added to responses
        'x_frame_options' => 'DENY',
        'x_content_type_options' => 'nosniff',
        'x_xss_protection' => '1; mode=block',
        'strict_transport_security' => 'max-age=31536000; includeSubDomains',
        'content_security_policy' => "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';",
    ],

    'monitoring' => [
        // Suspicious activity thresholds
        'suspicious_activity_threshold' => env('SUSPICIOUS_ACTIVITY_THRESHOLD', 5),
        'suspicious_activity_window' => env('SUSPICIOUS_ACTIVITY_WINDOW', 10), // minutes
        
        // Alert settings
        'enable_security_alerts' => env('ENABLE_SECURITY_ALERTS', true),
        'alert_email' => env('SECURITY_ALERT_EMAIL', 'security@veritas.edu.ng'),
    ],
];