<?php

namespace App\Application\UseCases\Admin\Category\CreateCategory;

class CreateCategoryOutput
{
    public function __construct(
        public int    $id,
    )
    {
    }
}