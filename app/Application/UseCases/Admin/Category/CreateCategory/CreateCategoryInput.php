<?php

namespace App\Application\UseCases\Admin\Category\CreateCategory;

class CreateCategoryInput
{
    public function __construct(
        public array $name,
    )
    {
        
    }
}