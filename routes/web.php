<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\StudentPasswordController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TranscriptStaffAuthController;

Route::get('/', function () {
    return redirect()->route('student.login');
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route::group(['prefix' => 'admin'], function() {
//     Route::post('login', [AdminController::class, 'login']);
//     Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//     Route::post('update-status/{id}', [AdminController::class, 'updateApplicationStatus']);
// });


Route::prefix('student')->name('student.')->group(function() {

    // Authentication Routes
    Route::get('login', [StudentAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [StudentAuthController::class, 'login'])->name('login.submit');
    Route::post('logout', [StudentAuthController::class, 'logout'])->name('logout');

    // Matric Number Verification and Email Update
    Route::post('matric/process', [StudentAuthController::class, 'processMatric'])->name('matric.process');
    Route::get('email/update', [StudentAuthController::class, 'showEmailUpdate'])->name('email.update');
    Route::post('email/update', [StudentAuthController::class, 'updateEmail'])->name('email.update.submit');
    Route::get('email/verification-sent', [StudentAuthController::class, 'showVerificationSent'])->name('email.verification.sent');
    Route::post('email/resend', [StudentAuthController::class, 'resendVerification'])->name('email.resend');

    // Password Setup (after email verification)
    Route::get('password/setup', [StudentAuthController::class, 'showPasswordSetup'])->name('password.setup');
    Route::post('password/setup', [StudentAuthController::class, 'setupPassword'])->name('password.setup.submit');

    // Password Reset
    Route::get('password/reset', [StudentAuthController::class, 'showPasswordReset'])->name('password.reset');
    Route::post('password/reset', [StudentAuthController::class, 'sendPasswordResetEmail'])->name('password.reset.submit');
    Route::get('password/reset/confirm', [StudentAuthController::class, 'showPasswordResetConfirm'])->name('password.reset.confirm');
    Route::post('password/reset/confirm', [StudentAuthController::class, 'updatePassword'])->name('password.reset.update');

    // Security Questions Verification (Scenario 3)
    Route::post('security/verify', [StudentAuthController::class, 'verifySecurityQuestions'])->name('security.verify');

    // Email Verification Routes
    Route::get('/email/verify/{id}/{hash}', [StudentAuthController::class, 'verifyEmailWithHash'])
        ->middleware(['signed'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [StudentAuthController::class, 'resendVerification'])
        ->name('verification.send');

    // 1. Show Home Page (Handled by StudentController)
    Route::get('home', [StudentController::class, 'showHome'])->name('home');

    // 2. Show Matric Number Form (Handled by StudentController)
    Route::get('matric/form', [StudentController::class, 'showMatricForm'])->name('matric.form');

    // 3. Process Matric Number (Now handled by StudentAuthController above)

    // Routes that need password reset check
    Route::middleware(['force.password.reset'])->group(function() {
        // 4. Show Profile (Handled by StudentController)
        Route::get('profile', [StudentController::class, 'showProfile'])->name('profile');

        // 5. Show Edit Details Form (Email and Phone only) (Handled by StudentController)
        Route::get('edit/details', [StudentController::class, 'showEditDetails'])->name('edit.details');

        // 6. Update Student Details and Redirect to Payment (Handled by StudentController)
        Route::post('update/details', [StudentController::class, 'updateDetails'])->name('update.details');
    });

    // Protected Routes (Require Authentication)
    Route::middleware(['student.auth', 'student.session'])->group(function() {
        // 11. Show the Student Dashboard with Application Status (Handled by StudentController)
        Route::get('dashboard', [StudentController::class, 'showDashboard'])->name('dashboard');

        // Transcript Application Routes
        Route::prefix('transcript')->name('transcript.')->group(function() {
            Route::get('create', [StudentController::class, 'showTranscriptForm'])->name('create');
            Route::post('create', [StudentController::class, 'createTranscriptApplication'])->name('store');
            Route::get('pricing', [StudentController::class, 'getPricingInfo'])->name('pricing');
            Route::get('history', [StudentController::class, 'showTranscriptHistory'])->name('history');
            Route::get('{id}/progress', [StudentController::class, 'showTranscriptProgress'])->name('progress');
            Route::get('{id}', [StudentController::class, 'showTranscriptDetails'])->name('show');
            
            // Transcript Payment Routes (Remita)
            Route::get('payment/{transcriptId}', [PaymentController::class, 'showTranscriptPaymentForm'])->name('payment.form');
            Route::post('payment/{transcriptId}', [PaymentController::class, 'processTranscriptPayment'])->name('payment.process');
            Route::get('payment/{transcriptId}/success', [PaymentController::class, 'transcriptPaymentSuccess'])->name('payment.success');
            Route::get('payment/{transcriptId}/failure', [PaymentController::class, 'transcriptPaymentFailure'])->name('payment.failure');
            Route::get('payment/verify/{rrr}', [PaymentController::class, 'verifyTranscriptPayment'])->name('payment.verify');
            
            // Paystack Payment Routes
            Route::prefix('paystack')->name('paystack.')->group(function() {
                Route::get('payment/{transcriptId}', [App\Http\Controllers\PaystackController::class, 'showPaymentForm'])->name('payment.form');
                Route::post('payment/{transcriptId}/initialize', [App\Http\Controllers\PaystackController::class, 'initializePayment'])->name('payment.initialize');
                Route::get('payment/callback', [App\Http\Controllers\PaystackController::class, 'handleCallback'])->name('callback');
                Route::post('payment/verify', [App\Http\Controllers\PaystackController::class, 'verifyPayment'])->name('payment.verify');
                Route::get('payment/{transcriptId}/success', [App\Http\Controllers\PaystackController::class, 'paymentSuccess'])->name('payment.success');
                Route::get('payment/{transcriptId}/status', [App\Http\Controllers\PaystackController::class, 'getPaymentStatus'])->name('payment.status');
            });
        });

        // Payment History Route
        Route::get('payments', [StudentController::class, 'showPaymentHistory'])->name('payments');

        // 9. Show Payment Form Based on Application Type (Handled by PaymentController)
        Route::get('payment/form/{transId}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
        // Route::get('payment/form/{encryptedTransId}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');

        // 10. Process Payment and Update Transaction Status (Handled by PaymentController)
        Route::post('payment/process/{transId}', [PaymentController::class, 'processPayment'])->name('payment.process');

        // Optional: Show success and failure views for payment status (Handled by PaymentController)
        Route::get('payment/success/{paymentId}', [PaymentController::class, 'success'])->name('payment.success');
        Route::get('payment/failed/{paymentId}', [PaymentController::class, 'paymentFailed'])->name('payment.failed');

        Route::get('payment/verify/{rrr}', [PaymentController::class, 'verifyPayment'])->name('payment.verify');

        // Optional: Redirect to Remita payment page (Handled by PaymentController)
        Route::post('payment/redirect', [PaymentController::class, 'redirectPayment'])->name('remita.payment.redirect');
    });

    // Public Routes (No Authentication Required)
    // 7. Show Security Questions Form (For students who forgot their matric number) (Handled by StudentController)
    Route::get('security/questions', [StudentController::class, 'showSecurityQuestionsForm'])->name('security.questions');

    // 8. Verify Security Questions (Handled by StudentController)
    Route::post('security/verify', [StudentController::class, 'verifySecurityQuestions'])->name('security.verify');

    // Password Setup and Reset Routes (New Implementation)
    Route::get('password/setup', [StudentPasswordController::class, 'showPasswordSetup'])->name('password.setup');
    Route::post('password/setup', [StudentPasswordController::class, 'storePassword'])->name('password.store');
    Route::get('password/email/form', [StudentPasswordController::class, 'showEmailForm'])->name('password.email.form');
    Route::post('password/email/send', [StudentPasswordController::class, 'sendPasswordResetEmail'])->name('password.email.send');
    Route::get('password/reset/{token}', [StudentPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('password/reset', [StudentPasswordController::class, 'resetPassword'])->name('password.reset');
});

// Transcript Staff Routes
Route::prefix('transcript/staff')->name('transcript.staff.')->group(function() {
    // Authentication Routes (Public)
    Route::get('login', [TranscriptStaffAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [TranscriptStaffAuthController::class, 'login'])->name('login.submit');

    // Protected Routes (Require Staff Authentication)
    Route::middleware(['transcript.staff.auth'])->group(function() {
        // Dashboard
        Route::get('dashboard', [TranscriptStaffAuthController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [TranscriptStaffAuthController::class, 'logout'])->name('logout');
        
        // Profile
        Route::get('profile', [TranscriptStaffAuthController::class, 'showProfile'])->name('profile');
        Route::post('profile/update', [TranscriptStaffAuthController::class, 'updateProfile'])->name('profile.update');

        // Application Management (Transcript Officers and above)
        Route::middleware(['transcript.staff.role:transcript_officer,transcript_admin,transcript_supervisor'])->group(function() {
            Route::get('applications', [TranscriptStaffAuthController::class, 'applications'])->name('applications');
            Route::get('applications/{id}', [TranscriptStaffAuthController::class, 'showApplication'])->name('applications.show');
            Route::post('applications/{id}/update-status', [TranscriptStaffAuthController::class, 'updateApplicationStatus'])->name('applications.update-status');
        });

        // Payment Management (Payment Officers and above)
        Route::middleware(['transcript.staff.role:payment_officer,transcript_admin,transcript_supervisor'])->group(function() {
            Route::get('payments', [TranscriptStaffAuthController::class, 'payments'])->name('payments');
            Route::get('payments/{id}', [TranscriptStaffAuthController::class, 'showPayment'])->name('payments.show');
            Route::post('payments/{id}/verify', [TranscriptStaffAuthController::class, 'verifyPayment'])->name('payments.verify');
        });

        // Reports (Admin and Supervisor only)
        Route::middleware(['transcript.staff.role:transcript_admin,transcript_supervisor'])->group(function() {
            Route::get('reports', [TranscriptStaffAuthController::class, 'reports'])->name('reports');
            Route::get('reports/generate', [TranscriptStaffAuthController::class, 'generateReport'])->name('reports.generate');
        });

        // Staff Management (Admin and Supervisor only)
        Route::middleware(['transcript.staff.role:transcript_admin,transcript_supervisor'])->group(function() {
            Route::get('manage', [TranscriptStaffAuthController::class, 'manageStaff'])->name('manage');
            Route::get('manage/create', [TranscriptStaffAuthController::class, 'createStaff'])->name('manage.create');
            Route::post('manage/store', [TranscriptStaffAuthController::class, 'storeStaff'])->name('manage.store');
            Route::get('manage/{id}/edit', [TranscriptStaffAuthController::class, 'editStaff'])->name('manage.edit');
            Route::put('manage/{id}', [TranscriptStaffAuthController::class, 'updateStaff'])->name('manage.update');
            Route::delete('manage/{id}', [TranscriptStaffAuthController::class, 'deleteStaff'])->name('manage.delete');
            Route::post('manage/{id}/assign-role', [TranscriptStaffAuthController::class, 'assignRole'])->name('manage.assign-role');
            Route::delete('manage/{id}/remove-role', [TranscriptStaffAuthController::class, 'removeRole'])->name('manage.remove-role');
        });
    });
});

