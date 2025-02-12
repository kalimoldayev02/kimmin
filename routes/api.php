<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SlugController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\ProductController;

Route::prefix('admin')->name('admin.')->group(function() {
    Route::controller(AuthController::class)->group(function() {
        Route::post('/login', 'login')->name('login');
        Route::middleware(['auth:sanctum', 'role.admin'])->group(function() {
            Route::get('/check', 'check')->name('check');
            Route::post('/logout', 'logout')->name('logout');
        });
    });

    Route::middleware(['auth:sanctum', 'role.admin'])->group(function() {
        Route::post('/slug', [SlugController::class, 'generateSlug'])->name('generateSlug');

        Route::prefix('product')->controller(ProductController::class)->group(function () {
            Route::get('/list', 'getProducts')->name('getProducts');
            Route::post('/create', 'createProduct')->name('createProduct');
            Route::get('/{product}', 'getProduct')->name('getProduct');
            Route::post('/{product}/update', 'updateProduct')->name('updateProduct');
            Route::post('/{product}/delete', 'deleteProduct')->name('deleteProduct');
        });

        Route::prefix('file')->controller(FileController::class)->group(function() {
            Route::post('/upload', 'uploadFiles')->name('uploadFiles');
            Route::post('/delete', 'deleteFiles')->name('deleteFiles');
        });
    });
});