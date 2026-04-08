<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest.only')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth.session')->group(function () {
    Route::get('/dashboard', [PortalController::class, 'dashboard']);

    Route::get('/profile', [PortalController::class, 'editProfile']);
    Route::post('/profile', [PortalController::class, 'updateProfile']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
