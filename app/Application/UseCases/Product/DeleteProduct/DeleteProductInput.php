<?php

namespace App\Application\UseCases\Product\DeleteProduct;

class DeleteProductInput
{
    public function __construct(
        public int $productId
    )
    {
    }
}