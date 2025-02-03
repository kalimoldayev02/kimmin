<?php

namespace App\Application\UseCases\Product\DTO;

use App\Application\UseCases\File\DTO\FileOutput;

class GetProductOutput
{
    /**
     * @param int $id
     * @param string $nameRu
     * @param string $nameKk
     * @param string $nameEn
     * @param string $descriptionRu
     * @param string $descriptionKk
     * @param string $descriptionEn
     * @param string $slug
     * @param int $price
     * @param FileOutput[] $files
     * @param GetProductCategoryOutput[] $categories
     */
    public function __construct(
        public int    $id,
        public string $nameRu,
        public string $nameKk,
        public string $nameEn,
        public string $descriptionRu,
        public string $descriptionKk,
        public string $descriptionEn,
        public string $slug,
        public int    $price,
        public array  $files,
        public array  $categories
    )
    {
    }
}