<?php

namespace App\Application\UseCases\Admin\Product\DTO;

use App\Application\UseCases\Admin\File\DTO\FileOutput;

class GetProductCategoryOutput
{
    /**
     * @param int $id
     * @param string $nameRu
     * @param string $nameKk
     * @param string $nameEn
     * @param string $slug
     */
    public function __construct(
        public int    $id,
        public string $nameRu,
        public string $nameKk,
        public string $nameEn,
        public string $slug,
    )
    {
    }
}
