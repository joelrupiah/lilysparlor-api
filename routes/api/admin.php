<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Admin\AdminController;
use App\Http\Controllers\API\Admin\AuthController;
use App\Http\Controllers\API\Admin\Category\CategoryController;
use App\Http\Controllers\API\Admin\ProductClass\ProductClassController;
use App\Http\Controllers\API\Admin\Brand\BrandController;
use App\Http\Controllers\API\Admin\Product\ProductController;
use App\Http\Controllers\API\Admin\Service\ServiceController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\Admin\Order\OrdersController;

Route::post('admin/register',[AuthController::class, 'register'])->name('register');
Route::post('admin/login',[AuthController::class, 'login'])->name('login');

Route::middleware(['auth:admin-api', 'scope:admin'])->prefix('admin')->group(function () {

// Admins Routes
Route::get('get-all-admins', [AdminController::class, 'index']);

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
    Route::get('get-categories', [CategoryController::class, 'index']);
    Route::get('get-single-category/{id}', [CategoryController::class, 'show']);
    Route::post('edit-category/{id}', [CategoryController::class, 'update']);
    Route::delete('delete-category/{id}', [CategoryController::class, 'destroy']);

    // Product Class Routes
    Route::post('create-class', [ProductClassController::class, 'store']);
    Route::get('get-classes', [ProductClassController::class, 'index']);
    Route::get('get-single-class/{id}', [ProductClassController::class, 'show']);
    Route::post('edit-class/{id}', [ProductClassController::class, 'update']);
    Route::delete('delete-class/{id}', [ProductClassController::class, 'destroy']);

 // Product Routes
 Route::post('create-product', [ProductController::class, 'store']);
 Route::get('get-products', [ProductController::class, 'index']);
 Route::get('get-single-product/{id}', [ProductController::class, 'show']);
 Route::post('edit-product/{id}', [ProductController::class, 'update']);
 Route::delete('delete-product/{id}', [ProductController::class, 'destroy']);

 // Service Routes
 Route::post('create-service', [ServiceController::class, 'store']);
 Route::get('get-services', [ServiceController::class, 'index']);
 Route::get('get-single-service/{id}', [ServiceController::class, 'show']);
 Route::post('edit-service/{id}', [ServiceController::class, 'update']);
 Route::delete('delete-service/{id}', [ServiceController::class, 'destroy']);

// Brand Routes
    Route::post('create-brand', [BrandController::class, 'store']);


// Product Routes
    Route::post('create-product', [ProductController::class, 'store']);
    Route::get('get-all-products', [ProductController::class, 'index']);

    // Order Routes
    Route::get('all-user-order', [OrdersController::class, 'index']);
    // Route::get('order-details/{order_id}', [OrdersController::class, 'orderDetail']);
    Route::get('get-user-specific-order/{order_id}', [OrdersController::class, 'getUserSpecificOrder']);

});
