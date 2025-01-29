<?php

namespace App\Application\UseCases\Admin\Product\CreateProduct;

class CreateProductInput
{
    public function __construct(
        public string $nameRu,
        public string $nameKk,
        public string $nameEn,
        public string $descriptionRu,
        public string $descriptionKk,
        public string $descriptionEn,
        public array  $categoryIds,
        public array  $fileIds,
    )
    {
    }
}
