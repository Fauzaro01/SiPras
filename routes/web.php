<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AspirationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;

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
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Aspiration Routes
    Route::resource('aspirations', AspirationController::class);
    Route::post('/aspirations/{aspiration}/update-status', [AspirationController::class, 'updateStatus'])
        ->name('aspirations.update-status');
    Route::get('/histori', [AspirationController::class, 'histori'])->name('aspirations.histori');

    // Category Routes (Admin only)
    Route::resource('categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);

    // User Management Routes (Admin only)
    Route::resource('users', UserController::class)->only(['index', 'update', 'destroy']);
});
