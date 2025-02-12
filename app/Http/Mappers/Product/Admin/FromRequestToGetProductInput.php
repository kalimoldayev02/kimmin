<?php

namespace App\Http\Mappers\Product\Admin;

use App\Application\UseCases\Product\Admin\GetProduct\GetProductInput;

class FromRequestToGetProductInput
{
    public function map(int $productId): GetProductInput
    {
        return new GetProductInput($productId);
    }
}
