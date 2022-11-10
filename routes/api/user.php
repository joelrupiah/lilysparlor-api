<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\API\User\AuthController;

Route::post('register',[AuthController::class, 'register'])->name('register');
Route::post('login',[AuthController::class, 'login'])->name('login');

Route::group( ['middleware' => ['auth:api','scopes:user'] ],function(){
   // authenticated staff routes here
    Route::get('user', [UserController::class, 'index']);
    Route::get('users',[AuthController::class, 'index']);

});
