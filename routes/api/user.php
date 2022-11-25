<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\API\User\AuthController;
use App\Http\Controllers\API\Admin\Category\CategoryController;
use App\Http\Controllers\API\Admin\Product\ProductController;
use App\Http\Controllers\API\Admin\Service\ServiceController;
use App\Http\Controllers\API\User\CartController;
use App\Http\Controllers\API\User\OrdersController;

Route::post('register',[AuthController::class, 'register'])->name('register');
Route::post('login',[AuthController::class, 'login'])->name('login');

Route::middleware(['auth:api', 'scope:user'])->group(function () {
   // authenticated staff routes here
    Route::get('auth-user', [UserController::class, 'index']);
    Route::get('users',[AuthController::class, 'index']);

    Route::post('add-to-cart', [CartController::class, 'store']);
    Route::get('cart-items', [CartController::class, 'index']);
    Route::delete('delete-cart-item/{id}', [CartController::class, 'destroy']);
    Route::delete('delete-all-cart-items', [CartController::class, 'destroyAll']);

    Route::post('checkout', [OrdersController::class, 'store']);

});

Route::get('get-categories', [CategoryController::class, 'userIndex']);
Route::get('get-products', [ProductController::class, 'userIndex']);
Route::get('get-services', [ServiceController::class, 'userIndex']);
