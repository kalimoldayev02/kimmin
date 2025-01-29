<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\CategoryController;

Route::prefix('admin')->group(function() {
    Route::controller(AuthController::class)->group(function() {
        Route::post('/login', 'login')->name('admin.login');
        Route::post('/logout', 'logout')->middleware(['auth:sanctum', 'role.admin'])->name('admin.logout');
    });

    Route::middleware(['auth:sanctum', 'role.admin'])->group(function() {
        Route::prefix('category')->controller(CategoryController::class)->group(function() {
            Route::get('/', 'getCategories')->name('admin.get_categories');
            Route::post('/', 'createCategory')->name('admin.create_category');
            Route::get('/{category}', 'getCategory')->name('admin.get_category');
            Route::post('/{category}', 'updateCategory')->name('admin.update_category');
        });

        Route::prefix('file')->controller(FileController::class)->group(function() {
            Route::post('/upload', 'upload')->name('admin.file_upload');
            Route::post('/delete', 'delete')->name('admin.file_delete');
        });
    });
});