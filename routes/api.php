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
            Route::get('/', 'getCategories')->name('getCategories');
            Route::post('/', 'createCategory')->name('createCategory');
            Route::get('/{category}', 'getCategory')->name('getCategory');
            Route::post('/{category}', 'updateCategory')->name('updateCategory');
        });

        Route::prefix('product')->controller(ProductController::class)->group(function () {
            Route::post('/', 'createProduct')->name('createProduct');
        });

        Route::prefix('file')->controller(FileController::class)->group(function() {
            Route::post('/upload', 'upload')->name('uploadFile');
            Route::post('/delete', 'delete')->name('deleteFile');
        });
    });
});