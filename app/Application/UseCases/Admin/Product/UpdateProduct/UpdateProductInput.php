<?php

namespace App\Application\UseCases\Admin\Product\UpdateProduct;

class UpdateProductInput
{
    public function __construct(
        public int    $productId,
        public int    $price,
        public string $slug,
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
