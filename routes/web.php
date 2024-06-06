<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CrmController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Login routes
Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'index')->name('login');
    Route::post('/login', 'store')->name('login.store');
    Route::get('/logout', 'destroy')->name('login.destroy');
});

Route::middleware('auth')->group(function () {
    // Dashboard main page
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Transaction routes
    Route::controller(TransactionController::class)->group(function () {
        Route::get('/transactions', 'index')->name('transactions.index');
        Route::get('/transactions/view/{id}', 'view')->name('transactions.view');
        Route::get('/transactions/create', 'create')->name('transactions.create');
        Route::post('/transactions', 'store')->name('transactions.store');
        Route::post('/transactions/customers/{search}', 'searchCustomers')->name('transactions.customers');
        Route::post('/transactions/suppliers/{search}', 'searchSuppliers')->name('transactions.suppliers');
        Route::post('/transactions/products', 'searchProducts')->name('transactions.products');
        Route::post('/transactions/destroy/{id}', 'destroy')->name('transactions.destroy');
    });

    // Customer routes
    Route::resource('/customers', CustomerController::class)->except(['show', 'destroy']);
    Route::post('/customer/destroy/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // CRM routes
    Route::resource('/crm', CrmController::class)->except(['show', 'destroy']);
    Route::post('/crm/destroy/{id}', [CrmController::class, 'destroy'])->name('crm.destroy');
    Route::post('/crm/{crm}/close', [CrmController::class, 'closeContract'])->name('crm.close');

    // Supplier routes
    Route::resource('/suppliers', SupplierController::class)->except(['show', 'destroy']);
    Route::post('/suppliers/destroy/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    // Product routes
    Route::resource('/products', ProductController::class)->except(['show', 'destroy']);
    Route::post('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // User routes
    Route::resource('/users', UserController::class)->except(['show', 'destroy']);
    Route::post('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Settings routes
    Route::controller(SettingsController::class)->group(function () {
        Route::get('/settings', 'index')->name('settings.index');
    });

    // Settings routes
    Route::controller(PermissionController::class)->group(function () {
        Route::get('/permissions', 'index')->name('permissions.index');
        Route::post('/permissions', 'store')->name('permissions.store');
        Route::get('/permissions/fetch', 'fetchPermissions')->name('permissions.fetch');
    });
});
