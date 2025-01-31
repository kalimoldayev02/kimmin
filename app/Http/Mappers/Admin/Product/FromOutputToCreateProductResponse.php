<?php

namespace App\Http\Mappers\Admin\Product;

use App\Application\UseCases\Admin\Product\CreateProduct\CreateProductOutput;

class FromOutputToCreateProductResponse
{
    public function map(CreateProductOutput $output): array
    {
        return ['id' => $output->id];
    }
}
