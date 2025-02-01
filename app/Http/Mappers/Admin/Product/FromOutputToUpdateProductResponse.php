<?php

namespace App\Http\Mappers\Admin\Product;

use App\Application\UseCases\Admin\Product\UpdateProduct\UpdateProductOutput;

class FromOutputToUpdateProductResponse
{
    public function map(UpdateProductOutput $output): array
    {
        return ['id' => $output->id];
    }
}
