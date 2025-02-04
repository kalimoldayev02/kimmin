<?php

namespace App\Http\Mappers\Category;

use App\Application\UseCases\Category\CreateCategory\CreateCategoryInput;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;

class FromRequestToCreateInput
{
    public function map(CreateCategoryRequest $request): CreateCategoryInput
    {
        return new CreateCategoryInput(
            $request->validated('slug'),
            $request->validated('name.ru'),
            $request->validated('name.kk'),
            $request->validated('name.en'),
        );
    }
}