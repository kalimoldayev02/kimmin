<?php

namespace App\Http\Mappers\Admin\Product;

use App\Application\UseCases\Admin\Product\GetProduct\GetProductInput;

class FromRequestToGetProductInput
{
    public function map(int $productId): GetProductInput
    {
        return new GetProductInput($productId);
    }
}
