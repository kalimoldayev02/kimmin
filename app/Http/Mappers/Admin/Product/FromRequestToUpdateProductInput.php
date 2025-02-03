<?php

namespace App\Http\Mappers\Admin\Product;

use App\Application\UseCases\Product\UpdateProduct\UpdateProductInput;
use App\Http\Requests\Admin\Product\UpdateProductRequest;

class FromRequestToUpdateProductInput
{
    public function map(int $productId, UpdateProductRequest $request): UpdateProductInput
    {
        return new UpdateProductInput(
            $productId,
            $request->validated('price'),
            $request->validated('slug'),
            $request->validated('name.ru'),
            $request->validated('name.kk'),
            $request->validated('name.en'),
            $request->validated('description.ru'),
            $request->validated('description.kk'),
            $request->validated('description.en'),
            $request->validated('category_ids'),
            $request->validated('file_ids'),
        );
    }
}
