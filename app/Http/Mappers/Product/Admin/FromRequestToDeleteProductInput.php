<?php

namespace App\Http\Mappers\Product\Admin;

use App\Application\UseCases\Product\Admin\DeleteProduct\DeleteProductInput;

class FromRequestToDeleteProductInput
{
    public function map(int $productId): DeleteProductInput
    {
        return new DeleteProductInput($productId);
    }
}
