<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MejaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingpage.landingpage');
});
Route::redirect('/landingpage', '/');

Route::get('/menus', [MenuController::class, 'index']);
Route::get('/menu/category/{id}', [MenuController::class, 'byCategory']);
Route::get('/menu/{meja}', [MenuController::class, 'index']);

Route::get('/cart', [OrderController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/add/{id}', [OrderController::class, 'add'])->name('cart.add');

Route::post('/cart/minus/{id}', [OrderController::class, 'minus'])->name('cart.min');

Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');

Route::get('/order-status', [OrderController::class, 'orderStatus'])->name('order.status');

Route::get('/admin', [OrderController::class, 'admin'])->name('admin');
Route::post('/admin/orders/{id}/update', [OrderController::class, 'updateStatusManual'])->name('admin.order.update');