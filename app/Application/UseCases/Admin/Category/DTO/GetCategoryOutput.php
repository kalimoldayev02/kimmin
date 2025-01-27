<?php

namespace App\Application\UseCases\Admin\Category\DTO;

class GetCategoryOutput
{
    /**
     * @param int $id
     * @param string $nameRu
     * @param string $nameKk
     * @param string $nameEn
     * @param string $slug
     * @param FileOutput[] $files
     */
    public function __construct(
        public int    $id,
        public string $nameRu,
        public string $nameKk,
        public string $nameEn,
        public string $slug,
        public array  $files,
    )
    {
    }
}
