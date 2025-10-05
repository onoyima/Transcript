<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class RateLimitService
{
    /**
     * Check if verification attempts are within allowed limits
     */
    public static function checkVerificationLimit($identifier, $maxAttempts = 5, $timeWindow = 15)
    {
        $key = 'verification_attempts:' . md5($identifier . Request::ip());
        $attempts = Cache::get($key, 0);

        if ($attempts >= $maxAttempts) {
            return [
                'allowed' => false,
                'remaining_time' => Cache::store('file')->getStore()->getMetadata($key)['expires_at'] ?? $timeWindow
            ];
        }

        return ['allowed' => true, 'attempts' => $attempts];
    }

    /**
     * Record a verification attempt
     */
    public static function recordVerificationAttempt($identifier, $success = false, $timeWindow = 15)
    {
        $key = 'verification_attempts:' . md5($identifier . Request::ip());
        $attempts = Cache::get($key, 0);

        if ($success) {
            // Clear attempts on successful verification
            Cache::forget($key);
        } else {
            // Increment failed attempts
            Cache::put($key, $attempts + 1, now()->addMinutes($timeWindow));
        }
    }

    /**
     * Check payment processing rate limits
     */
    public static function checkPaymentLimit($studentId, $maxAttempts = 3, $timeWindow = 60)
    {
        $key = 'payment_attempts:' . $studentId . ':' . Request::ip();
        $attempts = Cache::get($key, 0);

        if ($attempts >= $maxAttempts) {
            return [
                'allowed' => false,
                'remaining_time' => $timeWindow
            ];
        }

        return ['allowed' => true, 'attempts' => $attempts];
    }

    /**
     * Record a payment attempt
     */
    public static function recordPaymentAttempt($studentId, $success = false, $timeWindow = 60)
    {
        $key = 'payment_attempts:' . $studentId . ':' . Request::ip();
        $attempts = Cache::get($key, 0);

        if ($success) {
            Cache::forget($key);
        } else {
            Cache::put($key, $attempts + 1, now()->addMinutes($timeWindow));
        }
    }

    /**
     * Check if login attempts are within allowed limits
     */
    public static function checkLoginAttempts($ipAddress, $maxAttempts = 5, $timeWindow = 15)
    {
        $key = 'login_attempts:' . md5($ipAddress);
        $attempts = Cache::get($key, 0);

        return $attempts < $maxAttempts;
    }

    /**
     * Record a login attempt
     */
    public static function recordLoginAttempt($ipAddress, $success = false, $timeWindow = 15)
    {
        $key = 'login_attempts:' . md5($ipAddress);
        $attempts = Cache::get($key, 0);

        if ($success) {
            // Clear attempts on successful login
            Cache::forget($key);
        } else {
            // Increment failed attempts
            Cache::put($key, $attempts + 1, now()->addMinutes($timeWindow));
        }
    }

    /**
     * Check for suspicious rapid requests
     */
    public static function checkRequestFrequency($action, $maxRequests = 10, $timeWindow = 5)
    {
        $key = 'request_frequency:' . $action . ':' . Request::ip();
        $requests = Cache::get($key, 0);

        if ($requests >= $maxRequests) {
            SecurityAuditService::logSuspiciousActivity('High frequency requests', [
                'action' => $action,
                'requests_count' => $requests,
                'time_window' => $timeWindow
            ]);

            return false;
        }

        Cache::put($key, $requests + 1, now()->addMinutes($timeWindow));
        return true;
    }
}