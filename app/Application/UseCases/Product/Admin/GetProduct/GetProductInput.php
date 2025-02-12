<?php

namespace App\Application\UseCases\Product\Admin\GetProduct;

class GetProductInput
{
    public function __construct(
        public int $id
    )
    {
    }
}