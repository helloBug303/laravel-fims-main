<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;


// Default route
Route::get('/', function () {
    return view('auth.login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard route (protected by auth middleware)
Route::middleware(['auth'])->group(function () {
// Admin Dashboard
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');
Route::get('/products/stock', [ProductController::class, 'showLowStock'])->name('products.lowstock');
Route::get('products/{id}/edit-stock', [ProductController::class, 'editStock'])->name('products.edit_stock');
Route::put('products/{id}/update-stock', [ProductController::class, 'updateStock'])->name('products.update_stock');
Route::get('/products/low-stock', [ProductController::class, 'lowStock'])->name('products.lowstock');


});

// Profile Routes (Only accessible to authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/sales/{sale}/edit', [SaleController::class, 'edit'])->name('sales.edit');
    Route::get('/account/edit', [ProfileController::class, 'editAccount'])->name('edit_account');
});

// Product Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/near-expiry', [ProductController::class, 'nearExpiry'])->name('products.near_expiry');
    Route::get('/products/expired', [ProductController::class, 'expired'])->name('products.expired');

    Route::get('/products/out-of-stock', [ProductController::class, 'outOfStock'])->name('products.outofstock');

    




});

// Media Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');
    Route::delete('/media/{id}', [MediaController::class, 'destroy'])->name('media.destroy');
});

// Category Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categorie', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');


});

// Sale Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');

    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('sales/{id}/edit', [SaleController::class, 'edit'])->name('sales.customEdit');
    Route::put('/sales/{id}', [SaleController::class, 'update'])->name('sales.update');
    Route::delete('/sales/{id}', [SaleController::class, 'destroy'])->name('sales.destroy');
});

// Sales Reports
Route::middleware(['auth'])->group(function () {
    Route::get('/sales/report', [SalesReportController::class, 'index'])->name('sales.report.index');
    Route::post('/sales/report/generate', [SalesReportController::class, 'generateReport'])->name('sales.report.byDates');
    Route::post('/sales/report/monthly', [SalesReportController::class, 'monthlyReport'])->name('sales.report.monthly');
    Route::get('/sales/report/daily', [SalesReportController::class, 'dailyReport'])->name('sales.report.daily');
    Route::get('/monthly-sales', [SaleController::class, 'monthlySales'])->name('sales.monthly');
    Route::get('/sales/daily', [SaleController::class, 'dailySales'])->name('sales.daily');
});

// Group and User Routes
Route::middleware(['auth'])->group(function () {
    // Groups
    Route::get('/group', [GroupController::class, 'index'])->name('group.index');
    Route::get('/group/create', [GroupController::class, 'create'])->name('group.create');
    Route::post('/group', [GroupController::class, 'store'])->name('group.store');
    Route::get('/group/{id}/edit', [GroupController::class, 'edit'])->name('group.edit');
    Route::put('/group/{id}', [GroupController::class, 'update'])->name('group.update');
    Route::delete('/group/{id}', [GroupController::class, 'destroy'])->name('group.destroy');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('user.edit');

});

// Settings Route
Route::middleware(['auth'])->get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');

// Admin Dashboard
Route::middleware(['auth'])->get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

// Reset password route (for local environment only)
if (app()->environment('local')) {
    Route::get('/reset-test-password', [AuthController::class, 'resetTestPassword']);
}



       
        

        
       