<?php

namespace App\Application\UseCases\Product\Admin\DeleteProduct;

class DeleteProductInput
{
    public function __construct(
        public int $productId
    )
    {
    }
}