<?php

namespace App\Application\UseCases\Product\UpdateProduct;

class UpdateProductOutput
{
    public function __construct(
        public int $id
    )
    {
    }
}
