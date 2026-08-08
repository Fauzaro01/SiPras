<?php

use App\Http\Controllers\AspirationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return view('landing');
})->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Routes (all authenticated users)
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/search', [\App\Http\Controllers\SearchController::class, 'search'])->name('search');

        // Aspiration Routes
        Route::resource('aspirations', AspirationController::class)->except(['edit', 'update']);
        Route::post('/aspirations/{aspiration}/update-status', [AspirationController::class, 'updateStatus'])
            ->name('aspirations.update-status')->middleware('admin');
        Route::get('/histori', [AspirationController::class, 'histori'])->name('aspirations.histori');

        // Feedback Routes (accessible by admin or the owner of aspiration)
        Route::post('/aspirations/{aspiration}/feedbacks', [FeedbackController::class, 'store'])
            ->name('feedbacks.store');

        // Password Change (all authenticated users)
        Route::get('/profile/change-password', [AuthController::class, 'changePasswordForm'])->name('password.change');
        Route::post('/profile/change-password', [AuthController::class, 'updatePassword'])->name('password.update');

        // Admin-only Routes
        Route::middleware('admin')->group(function () {
            // Export Route (F-03)
            Route::get('/export/aspirations', [\App\Http\Controllers\ExportController::class, 'exportCsv'])
                ->name('aspirations.export');

            // Feedback Destroy Routes
            Route::delete('/aspirations/{aspiration}/feedbacks/{feedback}', [FeedbackController::class, 'destroy'])
                ->name('feedbacks.destroy');

            // Category Routes
            Route::resource('categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);

            // User Management Routes
            Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'update', 'destroy']);
        });
    });
