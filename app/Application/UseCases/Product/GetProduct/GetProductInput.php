<?php

namespace App\Application\UseCases\Product\GetProduct;

class GetProductInput
{
    public function __construct(
        public int $id
    )
    {
    }
}