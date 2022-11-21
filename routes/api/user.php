<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\API\User\AuthController;
use App\Http\Controllers\API\Admin\Category\CategoryController;
use App\Http\Controllers\API\Admin\Product\ProductController;
use App\Http\Controllers\API\Admin\Service\ServiceController;
use App\Http\Controllers\API\User\CartController;

Route::post('register',[AuthController::class, 'register'])->name('register');
Route::post('login',[AuthController::class, 'login'])->name('login');

Route::group( ['middleware' => ['auth:user','scope:user'] ],function(){
   // authenticated staff routes here
    Route::get('auth-user', [UserController::class, 'index']);
    Route::get('users',[AuthController::class, 'index']);

    Route::post('add-to-cart', [CartController::class, 'store']);
});

Route::get('get-categories', [CategoryController::class, 'userIndex']);
Route::get('get-products', [ProductController::class, 'userIndex']);
Route::get('get-services', [ServiceController::class, 'userIndex']);
