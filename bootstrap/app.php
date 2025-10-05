<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'student.auth' => \App\Http\Middleware\StudentAuth::class,
            'student.session' => \App\Http\Middleware\ValidateStudentSession::class,
            'force.password.reset' => \App\Http\Middleware\ForcePasswordReset::class,
            'transcript.staff.auth' => \App\Http\Middleware\TranscriptStaffAuth::class,
            'transcript.staff.role' => \App\Http\Middleware\TranscriptStaffRole::class,
            'transcript.staff.permission' => \App\Http\Middleware\TranscriptStaffPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
