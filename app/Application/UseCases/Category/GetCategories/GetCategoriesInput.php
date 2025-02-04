<?php

namespace App\Application\UseCases\Category\GetCategories;

class GetCategoriesInput
{
    public function __construct(
        public int $page,
        public int $limit,
    )
    {
    }
}
