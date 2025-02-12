<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SlugController as AdminSlugController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\FileController as AdminFileController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\ProductController as ApiProductController;

Route::prefix('admin')->name('admin.')->group(function() {
    Route::controller(AdminAuthController::class)->group(function() {
        Route::post('/login', 'login')->name('login');
        Route::middleware(['auth:sanctum', 'role.admin'])->group(function() {
            Route::get('/check', 'check')->name('check');
            Route::post('/logout', 'logout')->name('logout');
        });
    });

    Route::middleware(['auth:sanctum', 'role.admin'])->group(function() {
        Route::post('/slug', [AdminSlugController::class, 'generateSlug'])->name('generateSlug');

        Route::prefix('product')->controller(AdminProductController::class)->group(function () {
            Route::get('/list', 'getProducts')->name('getProducts');
            Route::post('/create', 'createProduct')->name('createProduct');
            Route::get('/{product}', 'getProduct')->name('getProduct');
            Route::post('/{product}/update', 'updateProduct')->name('updateProduct');
            Route::post('/{product}/delete', 'deleteProduct')->name('deleteProduct');
        });

        Route::prefix('file')->controller(AdminFileController::class)->group(function() {
            Route::post('/upload', 'uploadFiles')->name('uploadFiles');
            Route::post('/delete', 'deleteFiles')->name('deleteFiles');
        });
    });
});

Route::prefix('product')->controller(ApiProductController::class)->group(function () {
    Route::get('/{slug}', 'getProductBySlug')->name('getProductBySlug');
    Route::get('/list', 'getProducts')->name('getProducts');
});