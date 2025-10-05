<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class SecurityAuditService
{
    /**
     * Log verification attempts
     */
    public static function logVerificationAttempt($type, $identifier, $success, $studentId = null, $additionalData = [])
    {
        $logData = [
            'verification_type' => $type, // 'matric_number' or 'security_questions'
            'identifier' => $identifier, // matric number or surname
            'success' => $success,
            'student_id' => $studentId,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'timestamp' => now(),
            'additional_data' => $additionalData
        ];

        if ($success) {
            Log::info('Successful student verification', $logData);
        } else {
            Log::warning('Failed student verification attempt', $logData);
        }
    }

    /**
     * Log duplicate application attempts
     */
    public static function logDuplicateApplicationAttempt($studentId, $existingApplicationStatus)
    {
        Log::warning('Duplicate application attempt blocked', [
            'student_id' => $studentId,
            'existing_application_status' => $existingApplicationStatus,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'timestamp' => now()
        ]);
    }

    /**
     * Log payment processing attempts
     */
    public static function logPaymentAttempt($studentId, $amount, $success, $transactionId = null, $error = null)
    {
        $logData = [
            'student_id' => $studentId,
            'amount' => $amount,
            'success' => $success,
            'transaction_id' => $transactionId,
            'ip_address' => Request::ip(),
            'timestamp' => now()
        ];

        if ($error) {
            $logData['error'] = $error;
        }

        if ($success) {
            Log::info('Payment processed successfully', $logData);
        } else {
            Log::error('Payment processing failed', $logData);
        }
    }

    /**
     * Log suspicious activities
     */
    public static function logSuspiciousActivity($activity, $details = [])
    {
        Log::alert('Suspicious activity detected', [
            'activity' => $activity,
            'details' => $details,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'timestamp' => now()
        ]);
    }

    /**
     * Log login attempts
     */
    public static function logLoginAttempt($userId, $ipAddress, $success, $details = [])
    {
        $logData = [
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'success' => $success,
            'details' => $details,
            'user_agent' => Request::userAgent(),
            'timestamp' => now()
        ];

        if ($success) {
            Log::info('Successful login attempt', $logData);
        } else {
            Log::warning('Failed login attempt', $logData);
        }
    }

    /**
     * Log session management events
     */
    public static function logSessionEvent($event, $studentId, $details = [])
    {
        Log::info('Session event', [
            'event' => $event, // 'created', 'expired', 'invalidated'
            'student_id' => $studentId,
            'details' => $details,
            'ip_address' => Request::ip(),
            'timestamp' => now()
        ]);
    }
}