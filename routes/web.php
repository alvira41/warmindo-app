<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MejaController;
use Illuminate\Support\Facades\Route;

Route::get('/landingpage', function () {
    return view('landingpage.landingpage');
});

Route::get('/menus', [MenuController::class, 'index']);
Route::get('/menu/category/{id}', [MenuController::class, 'byCategory']);
Route::get('/menu/{meja}', [MenuController::class, 'index']);

// ... rute lainnya ...

Route::get('/cart', [OrderController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/add/{id}', [OrderController::class, 'add'])->name('cart.add');

// Sesuaikan dengan nama fungsi baru: minus
Route::post('/cart/minus/{id}', [OrderController::class, 'minus'])->name('cart.min');

// Rute untuk memproses checkout
Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');

// Rute untuk menampilkan halaman status pesanan pelanggan
Route::get('/order-status', [OrderController::class, 'orderStatus'])->name('order.status');

// Pastikan memanggil adminDashboard
Route::get('/admin', [OrderController::class, 'adminDashboard'])->name('admin');
Route::post('/admin/orders/{id}/update', [OrderController::class, 'updateStatusManual'])->name('admin.order.update');