<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\User;
use App\Http\Middleware\Admin;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

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

            // Placeholders temporários
            Route::get('/usuarios', fn () => 'Gerenciar Usuários (em construção)')->name('user.usuarios');
            Route::get('/produtos', fn () => 'Gerenciar Produtos (em construção)')->name('user.produtos');
            Route::get('/compras', fn () => 'Histórico de compras (em construção)')->name('user.compras');
            Route::get('/vendas', fn () => 'Histórico de vendas (em construção)')->name('user.vendas');
        });
    });
});

Route::middleware('auth')->group(function (): void {
    Route::middleware(Admin::class)->group(function (): void {
        Route::prefix('admin')->group(function (): void {
            Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
            Route::get('/inicio', [ProductController::class, 'index'])->name('admin.inicio');
            Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
            Route::post('/products/create', [ProductController::class, 'store']);


            // Placeholders temporários
            Route::get('/usuarios', fn () => 'Gerenciar Usuários (em construção)')->name('admin.usuarios');
            Route::get('/produtos', fn () => 'Gerenciar Produtos (em construção)')->name('admin.produtos');
            Route::get('/admins', fn () => 'Gerenciar Admins (em construção)')->name('admin.admins');
            Route::get('/vendas', fn () => 'Histórico de vendas (em construção)')->name('admin.vendas');
        });
    });
});

//require __DIR__.'/auth.php';
