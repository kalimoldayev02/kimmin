<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CreateRequest;
use App\Application\UseCases\Admin\Category\CreateCategory\CreateCategoryUseCase;

class CategoryController extends Controller
{
    public function create(CreateRequest $createRequest, CreateCategoryUseCase $createCategoryUseCase)
    {

    }
}
