<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::get('/logout', [LoginController::class, 'destroy'])->name('login.destroy');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('/customers', CustomerController::class)->except(['show', 'destroy']);
    Route::post('/customer/destroy/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    Route::resource('/users', UserController::class)->except(['show', 'destroy']);
    Route::post('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Route::resource('/suppliers', SupplierController::class)->except(['show']);
});
