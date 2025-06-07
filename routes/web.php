<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdminController,
    OrderController,
    LokasiController,
    BillingController,
    PaymentController,
    ProfileController,
    SettingController,
    DashboardController,
    UserOrderController
};
use App\Http\Controllers\Auth\{
    RegisteredUserController,
    AuthenticatedSessionController,
    AdminAuthController
};

/*
|--------------------------------------------------------------------------
| Public Routes (Tidak perlu login)
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', function () {
    return view('index');
});

// Authentication Pages
Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/signup', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/signup', [RegisteredUserController::class, 'store']);

// User Order (Non-login)
Route::get('/user-order/create', [UserOrderController::class, 'index'])->name('user.form_pemesanan');
Route::post('/user-order', [UserOrderController::class, 'store'])->name('user_order.store');
Route::get('/user-order/download-pesanan/{id}', [UserOrderController::class, 'downloadPesanan'])->name('user_order.downloadPesanan');

// Check Status
Route::get('/user-order/check-status', [UserOrderController::class, 'checkStatusShow'])->name('check-status');
Route::post('/user-order/check-status', [UserOrderController::class, 'checkStatus'])->name('check-status-pesanan');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Perlu login)
|--------------------------------------------------------------------------
*/

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Order Management (Admin)
Route::get('/dashboard/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::put('/orders/update/{id}', [OrderController::class, 'update'])->name('orders.update');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

// Payment Management
Route::get('/dashboard/orders/payments', [PaymentController::class, 'history'])->name('payments.index');
Route::get('/payments/{id}', [PaymentController::class, 'show'])->name('payments.show');
Route::post('/payments/{id}/pay', [PaymentController::class, 'pay'])->name('payments.pay');
Route::get('/payments/{id}/download', [PaymentController::class, 'download'])->name('payments.download');

// Billing
Route::get('/bills/download', [BillingController::class, 'download'])->middleware('isSupervisor')->name('bills.download');

// Settings
Route::get('/settings', [SettingController::class, 'index'])->name('settings');

/*
|--------------------------------------------------------------------------
| Supervisor Only Routes
|--------------------------------------------------------------------------
*/

// Admin Management
Route::get('dashboard/management/admin', [AdminController::class, 'index'])->middleware('isSupervisor')->name('admin.management');
Route::post('/admin/add', [AdminController::class, 'store'])->middleware('isSupervisor')->name('admin.store');
Route::put('/admin/update/{id}', [AdminController::class, 'update'])->middleware('isSupervisor')->name('admin.update');
Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->middleware('isSupervisor')->name('admin.destroy');

// Lokasi
Route::post('/lokasi', [LokasiController::class, 'store'])->middleware('isSupervisor')->name('lokasi.store');
Route::put('/lokasi/update/{id}', [LokasiController::class, 'update'])->middleware('isSupervisor')->name('lokasi.update');
Route::delete('/lokasi/{id}', [LokasiController::class, 'destroy'])->middleware('isSupervisor')->name('lokasi.destroy');

// Export Excel
Route::get('/export/excel', [OrderController::class, 'export'])->middleware('isSupervisor')->name('orders.export');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';