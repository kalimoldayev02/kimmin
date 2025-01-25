<?php

namespace App\Http\Mappers\Admin\Category;

use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use App\Application\UseCases\Admin\Category\CreateCategory\CreateCategoryInput;

class FromRequestToCreateInput
{
    public function map(CreateCategoryRequest $request): CreateCategoryInput
    {
        return new CreateCategoryInput(
            $request->validated('name.ru'),
            $request->validated('name.kk'),
            $request->validated('name.en'),
            $request->validated('file_ids')
        );
    }
}