<?php

namespace App\Http\Mappers\Admin\Category;

use App\Application\UseCases\Admin\Category\GetCategory\GetCategoryInput;

class FromOutputToGetCategoryResponse
{
    public function map(int $id): GetCategoryInput
    {
        return new GetCategoryInput($id);
    }
}
