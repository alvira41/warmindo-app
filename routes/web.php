<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReportController;

/* =========================
   LANDING PAGE
========================= */

Route::get('/', function () {
    return view('landingpage.landingpage');
});

/* =========================
   AUTH
========================= */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* =========================
   ADMIN AREA
========================= */
Route::prefix('admin')->name('admin.')->group(function () {

    /* DASHBOARD */
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');

    /* =====================
       MENU MANAGEMENT
    ===================== */
    Route::get('/menu', [AdminController::class, 'menu'])
        ->name('menu');

    Route::get('/menu/create', [MenuController::class, 'create'])
        ->name('menu.create');

    Route::post('/menu/store', [MenuController::class, 'store'])
        ->name('menu.store');

    Route::get('/menu/edit/{id}', [MenuController::class, 'edit'])
        ->name('menu.edit');

    Route::post('/menu/update/{id}', [MenuController::class, 'update'])
        ->name('menu.update');

    Route::delete('/menu/delete/{id}', [MenuController::class, 'destroy'])
        ->name('menu.delete');

    Route::post('/admin/menu/image/{id}', [MenuController::class, 'updateImage'])
        ->name('menu.updateImage');

    Route::post('/menu/update-name/{id}', [MenuController::class, 'updateName'])
        ->name('menu.updateName');

    Route::post('/menu/update-price/{id}', [MenuController::class, 'updatePrice'])
        ->name('menu.updatePrice');

    Route::post('/admin/menu/harga_beli/{id}', [MenuController::class, 'updateHargaBeli'])
        ->name('menu.harga_beli');

    Route::post('/menu/update-stock/{id}', [AdminController::class, 'updateStock'])
        ->name('menu.updateStock');

    Route::post('/category/store', [CategoryController::class, 'store'])
        ->name('category.store');

    /* =====================
       CATEGORY MANAGEMENT
    ===================== */
    Route::get('/category', [CategoryController::class, 'index'])
        ->name('category.index');

    Route::get('/category/create', [CategoryController::class, 'create'])
        ->name('category.create');

    Route::post('/category/store', [CategoryController::class, 'store'])
        ->name('category.store');

    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])
        ->name('category.delete');

    /* =====================
       ORDER MANAGEMENT
    ===================== */
    Route::post('/orders/{id}/update', [OrderController::class, 'updateStatusManual'])
        ->name('order.update');

    Route::get('/report', [ReportController::class, 'index'])
        ->name('report');

    Route::get('/report/pdf/download', [ReportController::class, 'downloadPDF'])
        ->name('report.download');

    Route::get('/report/preview', [ReportController::class, 'previewPDF'])
        ->name('report.preview');
});

/* =========================
   USER MENU
========================= */
Route::get('/menu', [MenuController::class, 'index'])
    ->name('menu');

Route::get('/menu/category/{id}', [MenuController::class, 'byCategory'])
    ->name('menu.category');

/* =========================
   CART SYSTEM
========================= */
Route::prefix('cart')->name('cart.')->group(function () {

    Route::get('/', [CartController::class, 'index'])
        ->name('index');

    Route::post('/add/{id}', [CartController::class, 'add'])
        ->name('add');

    Route::post('/minus/{id}', [CartController::class, 'minus'])
        ->name('minus');

    Route::post('/delete/{id}', [CartController::class, 'delete'])
        ->name('delete');
});

/* =========================
   CHECKOUT
========================= */
Route::post('/checkout', [CheckoutController::class, 'checkout'])
    ->name('checkout');

Route::get('/order-status', [CheckoutController::class, 'status'])
    ->name('order.status');

/* =========================
   PRINT STRUK
========================= */
Route::get('/order/print/{id}', [OrderController::class, 'print'])
    ->name('order.print');

Route::post('/cart/note', [CartController::class, 'saveNote'])
    ->name('cart.note');


Route::get('/order/{id}/payment', [CheckoutController::class, 'payment'])->name('order.payment');
Route::post('/order/{id}/pay', [CheckoutController::class, 'processPayment'])->name('order.pay');

// 🔥 HALAMAN INPUT PEMBAYARAN
Route::get('/order/payment/{id}', [OrderController::class, 'payment'])
    ->name('order.payment');

// 🔥 PROSES PEMBAYARAN
Route::post('/order/pay/{id}', [OrderController::class, 'processPayment'])
    ->name('order.pay');
