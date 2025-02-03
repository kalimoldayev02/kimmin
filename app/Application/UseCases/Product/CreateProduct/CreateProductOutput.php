<?php

namespace App\Application\UseCases\Product\CreateProduct;

class CreateProductOutput
{
    public function __construct(
        public int $id
    )
    {
    }
}
