<?php

namespace App\Application\UseCases\Product\Admin\GetProducts;

class GetProductsInput
{
    public function __construct(
        public int $page,
        public int $limit,
    )
    {
    }
}
