<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PagSeguroController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\User;
use App\Http\Middleware\Admin;

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::get('/', function () {
    return view('auth/login');
});

Route::middleware('auth')->group(function (): void {

    Route::middleware(User::class)->group(function (): void {
        Route::prefix('user')->group(function (): void {
            Route::post('/logout', [LoginController::class, 'logout'])->name('user.logout');
            Route::get('/inicio', [ProductController::class, 'index'])->name('user.inicio');
            Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
            Route::post('/products/create', [ProductController::class, 'store']);
            Route::any('/products/search', [ProductController::class, 'search'])->name('user.products.search');

            // Placeholders temporários
            Route::get('/compras', fn () => 'Histórico de compras (em construção)')->name('user.compras');
            Route::get('/vendas', fn () => 'Histórico de vendas (em construção)')->name('user.vendas');
        });
    });

    Route::middleware(Admin::class)->group(function (): void {
        Route::prefix('admin')->group(function (): void {
            Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
            Route::get('/inicio', [ProductController::class, 'index'])->name('admin.inicio');

            Route::any('/products/search', [ProductController::class, 'search'])->name('admin.products.search');
            


            // Placeholders temporários
            Route::get('/admins', [ManagerController::class, 'index'])->name('admins');
            Route::get('/create', [ManagerController::class, 'create'])->name('admin.create');
            Route::post('/create', [ManagerController::class, 'store']);
            Route::get('/admin/{admin}/edit', [ManagerController::class, 'edit'])->name('admin.edit');
            Route::put('/admin/{admin}/edit', [ManagerController::class, 'update']);
            Route::delete('admin/{admin}', [ManagerController::class, 'destroy'])->name('admin.destroy');

            Route::get('/vendas', fn () => 'Histórico de vendas (em construção)')->name('admin.vendas');
        });
    });

    Route::get('/inicio', [ProductController::class, 'index'])->name('inicio');

    Route::get('/products/manage', [ProductController::class, 'manage'])->name('products.manage');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}/edit', [ProductController::class, 'update']);
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');

    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/create', [UserController::class, 'store']);
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}/edit', [UserController::class, 'update']);
    Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::get('/cart/{cartItem}', [CartController::class, 'edit'])->name('cart.update');
    Route::put('/cart/{cartItem}', [CartController::class, 'update']);
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::post('/checkout', [PagSeguroController::class, 'createCheckout'])->name('checkout');
    Route::get('/erroDePagamento', function () {return view('erroPagamento');})->name('erroPagamento');
});
