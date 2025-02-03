<?php

namespace App\Application\UseCases\Category\CreateCategory;

class CreateCategoryInput
{
    public function __construct(
        public string $slug,
        public string $nameRu,
        public string $nameKk,
        public string $nameEn,
    )
    {
    }
}