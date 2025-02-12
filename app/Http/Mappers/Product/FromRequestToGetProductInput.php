<?php

namespace App\Http\Mappers\Product;

use App\Application\UseCases\Product\Admin\GetProduct\GetProductInput;

class FromRequestToGetProductInput
{
    public function map(int $productId): GetProductInput
    {
        return new GetProductInput($productId);
    }
}
