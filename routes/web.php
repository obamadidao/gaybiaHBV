<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Các route cho admin
Route::prefix('admin')->middleware(['auth', CheckRole::class.':admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Các route cho user thường
Route::prefix('user')->middleware(['auth', CheckRole::class.':user'])->group(function () {
    Route::get('/', function () {
        return 'Đây là user dashboard';
    })->name('user.dashboard');
});