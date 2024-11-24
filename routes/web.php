<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;


// Rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Dashboard Routes
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/change-password', [AuthController::class, 'changePassword'])->name('profile.change-password');

    // Resource Routes
    Route::resource('users', UserController::class);
    Route::resource('events', EventController::class);
    Route::resource('tickets', TicketController::class);
    Route::resource('orders', OrderController::class);

    // Order Management Routes
    Route::post('/orders/{id}/reject', [OrderController::class, 'rejectOrder'])->name('orders.reject');
    Route::post('/orders/{id}/accept', [OrderController::class, 'acceptOrder'])->name('orders.accept');
    
    // Users Order
    Route::get('/user/tickets', [TicketController::class, 'userTickets'])->name('user.tickets.index');
    Route::get('/user/orders', [OrderController::class, 'userOrders'])->name('user.orders.index');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');