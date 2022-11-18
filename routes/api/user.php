<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\API\User\AuthController;
use App\Http\Controllers\API\Admin\Category\CategoryController;
use App\Http\Controllers\API\Admin\Product\ProductController;

Route::post('register',[AuthController::class, 'register'])->name('register');
Route::post('login',[AuthController::class, 'login'])->name('login');

Route::group( ['middleware' => ['auth:user','scopes:user'] ],function(){
   // authenticated staff routes here
    Route::get('user', [UserController::class, 'index']);
    Route::get('users',[AuthController::class, 'index']);

});

Route::get('get-categories', [CategoryController::class, 'userIndex']);
Route::get('get-products', [ProductController::class, 'userIndex']);
