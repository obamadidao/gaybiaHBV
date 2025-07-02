<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Các route cho admin
Route::middleware(['auth', CheckRole::class . ':admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');

        // Route cho biểu đồ doanh thu
        Route::get('/revenue-chart', [AdminController::class, 'getRevenueChart'])->name('revenue-chart');

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
        Route::get('/products/{product}/variants', [ProductController::class, 'getVariants'])->name('products.variants');

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
        Route::get('/orders/export', [OrderController::class, 'export'])->name('orders.export');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::patch('/orders/{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');

        // Inventory management routes
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('/inventory/export', [InventoryController::class, 'export'])->name('inventory.export');
        Route::get('/inventory/{variant}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
        Route::post('/inventory/{variant}', [InventoryController::class, 'update'])->name('inventory.update');
        // Route::resource('users', UserController::class);

        // Quản lý danh sách mã giảm giá
        Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
        Route::post('/coupons', [CouponController::class, 'store'])->name('coupons.store');
        Route::get('/coupons/{coupon}', [CouponController::class, 'show'])->name('coupons.show');
        Route::put('/coupons/{coupon}', [CouponController::class, 'update'])->name('coupons.update');

        // Banner routes
        Route::resource('banners', BannerController::class);
        Route::post('banners/{banner}/toggle-status', [BannerController::class, 'toggleStatus'])->name('banners.toggle-status');
        Route::post('banners/update-position', [BannerController::class, 'updatePosition'])->name('banners.update-position');
    });

// Các route cho user thường
Route::middleware(['auth', CheckRole::class . ':user'])
->prefix('')
    ->name('user.')
    ->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('client.index');
    });

// Client routes
Route::prefix('')->name('client.')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('index');
    Route::get('/category/{slug}', [ClientController::class, 'category'])->name('category');
    Route::get('/{slug}', [ClientController::class, 'category'])->name('category');
    Route::get('/product/{slug}', [ClientController::class, 'product'])->name('product');

    // Auth routes cho khách hàng (guest only)
    Route::middleware('guest')->group(function () {
        Route::get('/login-user', [ClientController::class, 'loginUser'])->name('login-user');
        Route::post('/login-user', [ClientController::class, 'handleLogin'])->name('handle-login');
        Route::get('/register-user', [ClientController::class, 'registerUser'])->name('register-user');
        Route::post('/register-user', [ClientController::class, 'handleRegister'])->name('handle-register');
    });

    // Auth routes cho khách hàng đã đăng nhập
    Route::middleware('auth')->group(function () {
        Route::post('/logout-user', [ClientController::class, 'logout'])->name('logout-user');
        Route::get('/profile-user', [ClientController::class, 'profile'])->name('profile-user');
        Route::put('/profile-user', [ClientController::class, 'updateProfile'])->name('update-profile-user');
    });

    Route::get('/contact', [ClientController::class, 'contact'])->name('contact');
});
