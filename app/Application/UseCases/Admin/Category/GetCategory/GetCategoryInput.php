<?php

namespace App\Application\UseCases\Admin\Category\GetCategory;

class GetCategoryInput
{
    public function __construct(
        public int $id,
    )
    {
    }
}
