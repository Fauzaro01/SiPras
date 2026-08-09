<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AspirationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Models\Aspiration;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    $totalAspirations = Aspiration::count();
    $totalSiswa = User::where('role', 'siswa')->count();
    $totalSelesai = Aspiration::where('status', 'selesai')->count();
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
    Route::get('/search', [SearchController::class, 'search'])->name('search');

    // Aspiration Routes
    Route::resource('aspirations', AspirationController::class)->except(['edit', 'update']);
    Route::post('/aspirations/{aspiration}/update-status', [AspirationController::class, 'updateStatus'])
        ->name('aspirations.update-status')->middleware('admin');
    Route::get('/histori', [AspirationController::class, 'histori'])->name('aspirations.histori');

    // Feedback Routes (accessible by admin or the owner of aspiration)
    Route::post('/aspirations/{aspiration}/feedbacks', [FeedbackController::class, 'store'])
        ->name('feedbacks.store');

    // Comment Routes
    Route::post('/aspirations/{aspiration}/comments', [CommentController::class, 'store'])
        ->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');

    // Profile Edit Routes (for all users)
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    // Password Change (all authenticated users)
    Route::get('/profile/change-password', [AuthController::class, 'changePasswordForm'])->name('password.change');
    Route::post('/profile/change-password', [AuthController::class, 'updatePassword'])->name('password.update');

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

    // Admin-only Routes
    Route::middleware('admin')->group(function () {
        // Export Route (F-03)
        Route::get('/export/aspirations', [ExportController::class, 'exportCsv'])
            ->name('aspirations.export');
        Route::get('/export/aspirations/pdf', [ExportController::class, 'exportPdf'])
            ->name('aspirations.export.pdf');

        // Feedback Destroy Routes
        Route::delete('/aspirations/{aspiration}/feedbacks/{feedback}', [FeedbackController::class, 'destroy'])
            ->name('feedbacks.destroy');

        // Category Routes
        Route::resource('categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);

        // User Management Routes
        Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'update', 'destroy']);

        // Activity Log Routes
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])
            ->name('activity-logs.index');
    });
});
