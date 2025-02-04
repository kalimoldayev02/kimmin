<?php

namespace App\Application\UseCases\Category\DeleteCategory;

class DeleteCategoryInput
{
    public function __construct(
        public int $categoryId
    )
    {
    }
}
