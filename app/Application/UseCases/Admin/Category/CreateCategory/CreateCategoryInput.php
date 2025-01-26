<?php

namespace App\Application\UseCases\Admin\Category\CreateCategory;

class CreateCategoryInput
{
    public function __construct(
        public string $nameRu,
        public string $nameKk,
        public string $nameEn,
        public array  $fileIds,
    )
    {
    }
}