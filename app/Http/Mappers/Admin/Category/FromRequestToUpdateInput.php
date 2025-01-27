<?php

namespace App\Http\Mappers\Admin\Category;

use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Application\UseCases\Admin\Category\UpdateCategory\UpdateCategoryInput;

class FromRequestToUpdateInput
{
    public function map(int $categoryId, UpdateCategoryRequest $request): UpdateCategoryInput
    {
        return new UpdateCategoryInput(
            $categoryId,
            $request->validated('slug'),
            $request->validated('name.ru'),
            $request->validated('name.kk'),
            $request->validated('name.en'),
            $request->validated('file_ids')
        );
    }
}