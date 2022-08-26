<?php

use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\OrderController;
use App\Http\Controllers\Api\v1\UserRegistrationController;
use App\Http\Controllers\Api\v1\UserAuthenticationController;

Route::prefix('registration')->group(function () {
    Route::post('/', [UserRegistrationController::class, 'post']);
    Route::get('verification/{token}', [UserRegistrationController::class, 'verification']);
});

Route::post('login', [UserAuthenticationController::class, 'login']);
Route::get('auth/user/{token}', [UserController::class, 'authUser']);

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'list']);
    Route::get('/{id}', [ProductController::class, 'product'])->whereNumber('id');
});

Route::prefix('orders')->middleware('user-auth')->group(function () {
    Route::post('/create', [OrderController::class, 'create']);
    Route::get('/story/{id}', [OrderController::class, 'userOrders'])->whereNumber('id');
});
