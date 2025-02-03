<?php

namespace App\Application\UseCases\Category\DTO;

class GetCategoryOutput
{
    /**
     * @param int $id
     * @param string $slug
     * @param string $nameRu
     * @param string $nameKk
     * @param string $nameEn
     */
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
