<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Halaman Web
Route::get('/', function () {
    return view('index');
});

Route::view('/admin', 'admin.listAdmin')->name('admin.management');

// halaman dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
// halaman Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// pemesanan User non-login
Route::get('/user-order/create', [UserOrderController::class, 'index'])->name('user.form_pemesanan');
Route::post('/user-order', [UserOrderController::class, 'store'])->name('user_order.store');
// donwload file pembayaran
Route::get('/user-order/download-pesanan/{id}', [UserOrderController::class, 'downloadPesanan'])->name('user_order.downloadPesanan');
// Check status
Route::get('/user-order/check-status', [UserOrderController::class, 'checkStatusShow'])->name('check-status');
Route::post('/user-order/check-status', [UserOrderController::class, 'checkStatus'])->name('check-status-pesanan');


// Login
Route::get('/login', function () {
    return view('auth.login');
});
// Register
Route::get('/signup', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/signup', [RegisteredUserController::class, 'store']);


// Buat Pesanan Admin
// Halaman Pesanan
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
// Proses buat pesanan
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
// Edit Pesanan
Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
// Hapus Pesanan
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
// Untuk export Excel
Route::get('/orders/export-excel', [OrderController::class, 'exportToExcel'])->name('orders.export');


// Riwayat Pembayaran
Route::get('/orders/payments', [PaymentController::class, 'history'])->name('payments.index');
Route::get('/payments/{id}', [PaymentController::class, 'show'])->name('payments.show');
Route::post('/payments/{id}/pay', [PaymentController::class, 'pay'])->name('payments.pay');
Route::get('/payments/{id}/download', [PaymentController::class, 'download'])->name('payments.download');

// Unduh Tagihan
Route::get('/bills/download', [BillingController::class, 'download'])->name('bills.download');

// Setting
Route::get('/settings', [SettingController::class, 'index'])->name('settings');

require __DIR__.'/auth.php';
