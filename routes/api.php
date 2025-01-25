<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\CategoryController;

Route::prefix('admin')->group(function() {
    Route::controller(AuthController::class)->group(function() {
        Route::post('/login', 'login');
        Route::post('/logout', 'logout')->middleware(['auth:sanctum', 'role.admin']);
    });

    Route::middleware(['auth:sanctum', 'role.admin'])->group(function() {
        Route::prefix('categories')->controller(CategoryController::class)->group(function() {
            Route::post('/', 'create');
        });

        Route::prefix('files')->controller(FileController::class)->group(function() {
            Route::post('/upload', 'upload');
            Route::post('/delete', 'delete');
        });
    });
});