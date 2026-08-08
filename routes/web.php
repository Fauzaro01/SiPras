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

    $totalAspirations = \App\Models\Aspiration::count();
    $totalSiswa = \App\Models\User::where('role', 'siswa')->count();
    $totalSelesai = \App\Models\Aspiration::where('status', 'selesai')->count();
    $persenSelesai = $totalAspirations > 0 ? round(($totalSelesai / $totalAspirations) * 100) : 100;

    return view('landing', compact('totalAspirations', 'totalSiswa', 'persenSelesai'));
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

        // Comment Routes
        Route::post('/aspirations/{aspiration}/comments', [\App\Http\Controllers\CommentController::class, 'store'])
            ->name('comments.store');
        Route::delete('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy'])
            ->name('comments.destroy');

        // Profile Edit Routes (for all users)
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

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

            // Activity Log Routes
            Route::get('/activity-logs', [\App\Http\Controllers\ActivityLogController::class, 'index'])
                ->name('activity-logs.index');
        });
    });
