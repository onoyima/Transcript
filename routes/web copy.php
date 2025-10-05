<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('student.home');
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route::group(['prefix' => 'admin'], function() {
//     Route::post('login', [AdminController::class, 'login']);
//     Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//     Route::post('update-status/{id}', [AdminController::class, 'updateApplicationStatus']);
// });



Route::prefix('student')->name('student.')->group(function() {

    // 1. Show Home/Index Page
    Route::get('home', [StudentController::class, 'showHome'])->name('home');

    // 2. Show Matric Number Form
    Route::get('matric/form', [StudentController::class, 'showMatricForm'])->name('matric.form');

    // 3. Process Matric Number
    Route::post('matric/process', [StudentController::class, 'processMatric'])->name('matric.process');

    // 4. Show Profile
    Route::get('profile', [StudentController::class, 'showProfile'])->name('profile');

    // 5. Show the Edit Details Form (Email and Phone only)
    Route::get('edit/details', [StudentController::class, 'showEditDetails'])->name('edit.details');

    // 6. Update Student Details and Redirect to Payment
    Route::post('update/details', [StudentController::class, 'updateDetails'])->name('update.details');

    // 7. Show Security Questions Form (For students who forgot their matric number)
    Route::get('security/questions', [StudentController::class, 'showSecurityQuestionsForm'])->name('security.questions');

    // 8. Verify Security Questions
    Route::post('security/verify', [StudentController::class, 'verifySecurityQuestions'])->name('security.verify');

    // 9. Show Payment Form Based on Application Type
    Route::get('payment/form/{transId}', [StudentController::class, 'showPaymentForm'])->name('payment.form');

    // 10. Process Payment and Update Transaction Status
    Route::post('payment/process/{transId}', [StudentController::class, 'processPayment'])->name('payment.process');

    // 11. Show the Student Dashboard with Application Status
    Route::get('dashboard', [StudentController::class, 'showDashboard'])->name('dashboard');


Route::get('/payment/{transId}', [PaymentController::class, 'showPaymentForm'])->name('student.payment.form');
Route::post('/payment/redirect', [PaymentController::class, 'redirectPayment'])->name('remita.payment.redirect');

});
