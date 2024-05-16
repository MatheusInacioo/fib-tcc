<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CrmController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
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

    // CRM routes
    Route::resource('/crm', CrmController::class)->except(['show', 'destroy', 'edit']);
    Route::post('/crm/destroy/{id}', [CrmController::class, 'destroy'])->name('crm.destroy');

    // Customer routes
    Route::resource('/customers', CustomerController::class)->except(['show', 'destroy']);
    Route::post('/customer/destroy/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // Supplier routes 
    Route::resource('/suppliers', SupplierController::class)->except(['show', 'destroy']);
    Route::post('/suppliers/destroy/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    // Product routes 
    Route::resource('/products', ProductController::class)->except(['show', 'destroy']);
    Route::post('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // User routes
    Route::resource('/users', UserController::class)->except(['show', 'destroy']);
    Route::post('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});
