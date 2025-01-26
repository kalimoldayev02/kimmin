<?php

namespace App\Application\UseCases\Admin\Category\UpdateCategory;

class UpdateCategoryInput
{
    public function __construct(
        public int    $categoryId,
        public string $slug,
        public string $nameRu,
        public string $nameKk,
        public string $nameEn,
        public array  $fileIds,
    )
    {
    }
}