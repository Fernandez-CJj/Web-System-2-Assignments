<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TradeItemController;
use App\Http\Controllers\TradeMessageController;
use App\Http\Controllers\TradeRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['auth', 'account.active'])->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/players', [PlayerController::class, 'index'])->name('players.index');
    Route::get('/players/{user}', [ProfileController::class, 'show'])->name('players.show');

    Route::resource('items', TradeItemController::class)->except(['show']);
    Route::get('/trades', [TradeRequestController::class, 'index'])->name('trades.index');
    Route::post('/items/{item}/trades', [TradeRequestController::class, 'store'])->name('trades.store');
    Route::post('/trades/{trade}/messages', [TradeMessageController::class, 'store'])->name('trades.messages.store');
    Route::patch('/trades/{trade}', [TradeRequestController::class, 'update'])->name('trades.update');
    Route::patch('/trades/{trade}/confirm', [TradeRequestController::class, 'confirm'])->name('trades.confirm');
    Route::post('/trades/{trade}/ratings', [RatingController::class, 'store'])->name('ratings.store');

    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}', [NotificationController::class, 'update'])->name('notifications.update');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::patch('/admin/reports/{report}', [AdminController::class, 'updateReport'])->name('admin.reports.update');
    Route::patch('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::patch('/admin/items/{item}/status', [AdminController::class, 'updateItemStatus'])->name('admin.items.status');
    Route::get('/admin/logs', [AdminController::class, 'logs'])->name('admin.logs');
});
