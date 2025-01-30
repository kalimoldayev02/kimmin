<?php

namespace App\Http\Mappers\Admin\Product;

use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Application\UseCases\Admin\Product\UpdateProduct\UpdateProductInput;

class FromRequestToUpdateInput
{
    public function map(UpdateProductRequest $request): UpdateProductInput
    {
        return new UpdateProductInput(
            $request->validated('product_id'),
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
