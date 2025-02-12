<?php

namespace App\Http\Mappers\Product;

use App\Application\UseCases\Product\DeleteProduct\DeleteProductInput;

class FromRequestToDeleteProductInput
{
    public function map(int $productId): DeleteProductInput
    {
        return new DeleteProductInput($productId);
    }
}
