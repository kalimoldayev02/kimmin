<?php

namespace App\Http\Mappers\Category;

use App\Application\UseCases\Category\UpdateCategory\UpdateCategoryInput;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;

class FromRequestToUpdateCategoryInput
{
    public function map(int $categoryId, UpdateCategoryRequest $request): UpdateCategoryInput
    {
        return new UpdateCategoryInput(
            $categoryId,
            $request->validated('slug'),
            $request->validated('name.ru'),
            $request->validated('name.kk'),
            $request->validated('name.en'),
        );
    }
}