<?php

namespace App\Application\UseCases\Category\UpdateCategory;

class UpdateCategoryInput
{
    public function __construct(
        public int    $id,
        public string $slug,
        public string $nameRu,
        public string $nameKk,
        public string $nameEn,
    )
    {
    }
}
