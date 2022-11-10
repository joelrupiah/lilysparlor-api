<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Admin\AdminController;
use App\Http\Controllers\API\Admin\AuthController;
use App\Http\Controllers\API\Admin\Category\CategoryController;
use App\Http\Controllers\API\Admin\Brand\BrandController;
use App\Http\Controllers\API\Admin\Product\ProductController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\RoleController;

Route::post('admin/register',[AuthController::class, 'register'])->name('register');
Route::post('admin/login',[AuthController::class, 'login'])->name('login');

    Route::middleware(['auth:admin-api', 'scope:admin'])->prefix('admin')->group(function () {


// Permission Routes
Route::get('get-permissions', [PermissionController::class, 'index']);
Route::get('admin/get-permission/{id}', [PermissionController::class, 'show']);
Route::post('create-permission', [PermissionController::class, 'store']);


// Roles Routes
Route::get('admin/get-roles', [RoleController::class, 'index']);
Route::get('admin/get-role/{id}', [RoleController::class, 'show']);
Route::post('admin/create-role', [RoleController::class, 'store']);


// Admin Data Routes
    Route::get('user', [UserController::class, 'index']);
    Route::get('users',[AuthController::class, 'index']);


// Category Routes
    Route::post('create-category', [CategoryController::class, 'store']);


// Brand Routes
    Route::post('create-brand', [BrandController::class, 'store']);


// Product Routes
    Route::post('create-product', [ProductController::class, 'store']);
    Route::get('get-all-products', [ProductController::class, 'index']);

});
