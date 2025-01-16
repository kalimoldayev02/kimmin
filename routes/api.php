<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::prefix('admin')->group(function() {
    Route::controller(AuthController::class)->group(function() {
        Route::post('/registration', 'registration');
        Route::post('/login', 'login');
    });
});