<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;

Route::prefix('admin')->name('admin.')->group(function() {
    Route::controller(AuthController::class)->group(function() {
        Route::post('/login', 'login')->name('login');
        Route::post('/logout', 'logout')->middleware(['auth:sanctum', 'role.admin'])->name('logout');
    });

    Route::middleware(['auth:sanctum', 'role.admin'])->group(function() {
        Route::prefix('category')->controller(CategoryController::class)->group(function() {
            Route::get('/list', 'getCategories')->name('getCategories');
            Route::post('/create', 'createCategory')->name('createCategory');
            Route::get('/{category}', 'getCategory')->name('getCategory');
            Route::post('/{category}/update', 'updateCategory')->name('updateCategory');
        });

        Route::prefix('product')->controller(ProductController::class)->group(function () {
            Route::post('/create', 'createProduct')->name('createProduct');
            Route::get('/{product}', 'getProduct')->name('getProduct');
            Route::post('/{product}/update', 'updateProduct')->name('updateProduct');
        });

        Route::prefix('file')->controller(FileController::class)->group(function() {
            Route::post('/upload', 'uploadFiles')->name('uploadFiles');
            Route::post('/delete', 'deleteFiles')->name('deleteFiles');
        });
    });
});