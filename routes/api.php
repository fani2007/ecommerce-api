<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\UserProfileController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\TagController;
use App\Http\Controllers\API\ReviewController;

use App\Http\Middleware\CheckGroupHeader;
use App\Http\Middleware\CheckUserIdRequired;
use App\Http\Middleware\CheckCategoryName;
use App\Http\Middleware\CheckProductStock;
use App\Http\Middleware\CheckOrderStatus;
use App\Http\Middleware\CheckTagName;


Route::middleware([CheckGroupHeader::class])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});

Route::middleware([CheckUserIdRequired::class])->group(function () {
    Route::get('/user-profiles', [UserProfileController::class, 'index']);
    Route::post('/user-profiles', [UserProfileController::class, 'store']);
    Route::get('/user-profiles/{id}', [UserProfileController::class, 'show']);
    Route::put('/user-profiles/{id}', [UserProfileController::class, 'update']);
    Route::delete('/user-profiles/{id}', [UserProfileController::class, 'destroy']);
});

Route::middleware([CheckCategoryName::class])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
});

Route::middleware([CheckProductStock::class])->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
});

Route::middleware([CheckOrderStatus::class])->group(function () {
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/orders/{id}/items', [OrderController::class, 'addItem']);
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
});

Route::middleware([CheckTagName::class])->group(function () {
    Route::get('/tags', [TagController::class, 'index']);
    Route::post('/tags', [TagController::class, 'store']);
    Route::get('/tags/{id}', [TagController::class, 'show']);
    Route::delete('/tags/{id}', [TagController::class, 'destroy']);
    Route::put('/products/{productId}/tag/{tagId}', [TagController::class, 'attachToProduct']);
    Route::delete('/products/{productId}/tag/{tagId}', [TagController::class, 'detachFromProduct']);
});


Route::get('/reviews', [ReviewController::class, 'index']);
Route::post('/reviews', [ReviewController::class, 'store']);
Route::put('/reviews/{id}/approve', [ReviewController::class, 'approve']);