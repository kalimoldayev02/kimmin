<?php

namespace App\Application\UseCases\Admin\Product\GetProduct;

class GetProductInput
{
    public function __construct(
        public int $id
    )
    {
    }
}