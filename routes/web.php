<?php

use App\Http\Controllers\Auth\LoginController;
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
            Route::get('/inicio', function (): \Illuminate\View\View {
                return view('inicio');
            })->name('inicio');
        });
    });
});

Route::middleware('auth')->group(function (): void {
    Route::middleware(Admin::class)->group(function (): void {
        Route::prefix('admin')->group(function (): void {
            Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
            Route::get('/inicio', function (): \Illuminate\View\View {
                return view('admin.inicio');
            })->name('admin.inicio');
        });
    });
});

//require __DIR__.'/auth.php';
