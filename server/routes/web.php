<?php

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminRegistrationController;
use App\Http\Controllers\AdminAuthController;

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

Route::prefix('registration')->name('registration.')->group(function () {
    Route::get('/', [AdminRegistrationController::class, 'view'])->name('register-page');
    Route::post('/', [AdminRegistrationController::class, 'post'])->name('register');
    Route::get('verification/{token}', [AdminRegistrationController::class, 'verification'])->name('verification');
});


Route::get('/', [AdminAuthController::class, 'view'])->name('login-page');
Route::post('/', [AdminAuthController::class, 'auth'])->name('login');
Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');


Route::prefix('admins')->middleware('admin-verification')->name('admins.')->group(function () {
    Route::get('/', [AdminController::class, 'list'])->name('list');
    Route::get('/{id}', [AdminController::class, 'admin'])->whereNumber('id')->name('admin');
    Route::get('/{id}/edit', [AdminController::class, 'edit'])->whereNumber('id')->name('edit');
    Route::put('/{id}/update', [AdminController::class, 'update'])->whereNumber('id')->name('update');
    Route::match(['get', 'delete'], '/{id}/delete', [AdminController::class, 'delete'])
        ->whereNumber('id')->name('delete');
});

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'list'])->name('list');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->whereNumber('id')->name('edit');
    Route::put('/{id}', [UserController::class, 'update'])->whereNumber('id')->name('update');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::match(['get', 'delete'], '/{id}', [UserController::class, 'delete'])
        ->whereNumber('id')->name('delete');
});

Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'list'])->name('list');
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->whereNumber('id')->name('edit');
    Route::put('/{id}', [ProductController::class, 'update'])->whereNumber('id')->name('update');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::match(['get', 'delete'], '/{id}', [ProductController::class, 'delete'])
        ->whereNumber('id')->name('delete');
});

Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'list'])->name('list');
    Route::get('/create', [OrderController::class, 'create'])->name('create');
    Route::post('/', [OrderController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [OrderController::class, 'edit'])->whereNumber('id')->name('edit');
    Route::put('/{id}', [OrderController::class, 'update'])->whereNumber('id')->name('update');
    Route::get('statistics', [OrderController::class, 'statistics'])->name('statistics');
});
