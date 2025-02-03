<?php

namespace App\Application\UseCases\Category\GetCategory;

class GetCategoryInput
{
    public function __construct(
        public int $id
    )
    {
    }
}
