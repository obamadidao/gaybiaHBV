<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
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
Route::middleware(['auth', CheckRole::class.':admin'])
->prefix('admin')
->name('admin.')
->group(function () {
Route::get('/', [AdminController::class, 'index'])->name('dashboard');

// Category routes
Route::resource('categories', CategoryController::class);
Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
Route::post('categories/bulk-action', [CategoryController::class, 'bulkAction'])->name('categories.bulk-action');
Route::get('categories-children', [CategoryController::class, 'getChildren'])->name('categories.children');

// Product routes
Route::resource('products', ProductController::class);
Route::post('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
Route::post('products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
Route::post('products/bulk-action', [ProductController::class, 'bulkAction'])->name('products.bulk-action');
Route::get('products/{product}/reviews', [ProductController::class, 'reviews'])->name('products.reviews');

// Product Review routes
Route::prefix('product-reviews')->name('product-reviews.')->group(function () {
Route::get('/', [ProductReviewController::class, 'index'])->name('index');
Route::get('/{review}', [ProductReviewController::class, 'show'])->name('show');
Route::post('/{review}/approve', [ProductReviewController::class, 'approve'])->name('approve');
Route::post('/{review}/reject', [ProductReviewController::class, 'reject'])->name('reject');
Route::post('/{review}/hide', [ProductReviewController::class, 'hide'])->name('hide');
Route::post('/{review}/unhide', [ProductReviewController::class, 'unhide'])->name('unhide');
Route::delete('/{review}', [ProductReviewController::class, 'destroy'])->name('destroy');
Route::post('/{review}/update-notes', [ProductReviewController::class, 'updateNotes'])->name('update-notes');
Route::post('/bulk-action', [ProductReviewController::class, 'bulkAction'])->name('bulk-action');
Route::get('/statistics', [ProductReviewController::class, 'statistics'])->name('statistics');
});

// Customer routes
Route::prefix('customers')->name('customers.')->group(function () {
Route::get('/', [CustomerController::class, 'index'])->name('index');
Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
Route::put('/{customer}', [CustomerController::class, 'update'])->name('update');
Route::post('/{customer}/verify', [CustomerController::class, 'verify'])->name('verify');
Route::post('/{customer}/unverify', [CustomerController::class, 'unverify'])->name('unverify');
Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
});

// Order management routes
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
Route::patch('/orders/{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');
        Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');

// Route::resource('users', UserController::class);
});

// Các route cho user thường
Route::middleware(['auth', CheckRole::class.':user'])
->prefix('user')
->name('user.')
->group(function () {
Route::get('/', function () {
return 'Đây là user dashboard';
})->name('dashboard');