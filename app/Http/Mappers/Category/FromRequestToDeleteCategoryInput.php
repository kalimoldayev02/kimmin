<?php

namespace App\Http\Mappers\Category;

use App\Application\UseCases\Category\DeleteCategory\DeleteCategoryInput;

class FromRequestToDeleteCategoryInput
{
    public function map(int $categoryId): DeleteCategoryInput
    {
        return new DeleteCategoryInput($categoryId);
    }
}
