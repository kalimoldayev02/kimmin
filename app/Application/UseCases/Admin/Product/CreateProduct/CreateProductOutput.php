<?php

namespace App\Application\UseCases\Admin\Product\CreateProduct;

class CreateProductOutput
{
    public function __construct(
        public int $id
    )
    {
    }
}
