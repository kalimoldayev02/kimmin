<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ForbiddenController;

Route::any('{all}', [ForbiddenController::class, 'forbidden'])
    ->where('all', '^(?!api).*$');

