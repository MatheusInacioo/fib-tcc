<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CrmController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\InvoicingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\RoleController;
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
    Route::get('/recover', 'recover')->name('login.recover');
    Route::get('/teste', 'teste')->name('teste');
});

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware('auth')->group(function () {
    // Dashboard routes
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard.index');
        Route::get('/dashboard/filter/{period}/{chartType}', 'filterData')->name('dashboard.filter');
        Route::get('/dashboard/invoicing', 'invoicing')->name('dashboard.invoicing');
    });

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
        Route::get('/transactions/export', 'export')->name('transactions.export');
    });

    // Customer routes
    Route::resource('/customers', CustomerController::class)->except(['show', 'destroy']);
    Route::post('/customers/destroy/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('/customers/export', [CustomerController::class, 'export'])->name('customers.export');

    // CRM routes
    Route::resource('/crm', CrmController::class)->except(['show', 'destroy']);
    Route::post('/crm/destroy/{id}', [CrmController::class, 'destroy'])->name('crm.destroy');
    Route::post('/crm/{crm}/close', [CrmController::class, 'closeContract'])->name('crm.close');

    // Supplier routes
    Route::resource('/suppliers', SupplierController::class)->except(['show', 'destroy']);
    Route::post('/suppliers/destroy/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
    Route::get('/suppliers/export', [SupplierController::class, 'export'])->name('suppliers.export');

    // Product routes
    Route::resource('/products', ProductController::class)->except(['show', 'destroy']);
    Route::post('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
    Route::get('/products/replace/{id}', [ProductController::class, 'replace'])->name('products.replace');

    // User routes
    Route::resource('/users', UserController::class)->except(['show', 'destroy']);
    Route::post('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/export', [UserController::class, 'export'])->name('users.export');

    // Settings routes
    Route::controller(SettingsController::class)->group(function () {
        Route::get('/settings', 'index')->name('settings.index');
    });

    // Settings routes
    Route::controller(PermissionController::class)->group(function () {
        Route::get('/permissions', 'index')->name('permissions.index');
        Route::post('/permissions', 'store')->name('permissions.store');
        Route::post('/permissions/create-role', 'createRole')->name('permissions.create-role');
        Route::get('/permissions/fetch', 'fetchPermissions')->name('permissions.fetch');
    });

    Route::controller(RoleController::class)->group(function () {
        Route::post('/roles', 'store')->name('roles.store');
        Route::put('/roles/{id}', 'update')->name('roles.update');
        Route::post('/roles/destroy/{id}', 'destroy')->name('roles.destroy');
    });

    // Invoicing routes
    Route::controller(InvoicingController::class)->group(function () {
        Route::get('/invoicing', 'index')->name('invoicing.index');
    });
});
