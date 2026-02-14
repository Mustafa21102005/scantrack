<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

// routes that need the user to be authenticated and verified
Route::middleware(['auth', 'verified'])->group(function () {

    // admin routes
    Route::middleware(['role:admin'])->group(function () {

        Route::resource('courses', CourseController::class)->except('show');

        Route::resource('users', UserController::class)->except('show');

        Route::post('/students/{user}/enroll', [UserController::class, 'enroll'])->name('students.enroll');

        Route::delete('/students/{user}/courses/{course}', [UserController::class, 'unenroll'])
            ->name('students.unenroll');
    });

    // lecturer routes
    Route::middleware(['role:lecturer'])->group(function () {

        Route::get('attendances', [AttendanceController::class, 'index'])->name('attendances.index');

        Route::resource('qr-codes', CourseSessionController::class);

        Route::post('/qr/{qrCode}/expire', [CourseSessionController::class, 'expire'])->name('qr-codes.expire');
    });

    // student & lecturer routes
    Route::middleware(['role:student|lecturer'])->group(function () {
        Route::get('my/courses', [CourseController::class, 'my_courses'])->name('courses.me');
    });

    // student routes
    Route::middleware(['role:student'])->group(function () {
        Route::get('/my-attendance', [AttendanceController::class, 'myAttendance'])->name('attendances.me');
    });

    // admin & lecturer routes
    Route::middleware(['role:admin|lecturer'])->group(function () {

        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    });

    // routes for all users
    Route::middleware(['role:admin|lecturer|student'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    });
});

Route::get('/qr/scan/{token}', [CourseSessionController::class, 'scan'])->name('qr.scan');
