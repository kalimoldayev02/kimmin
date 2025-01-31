<?php

namespace App\Http\Mappers\Admin\Product;

use App\Http\Requests\Admin\Product\CreateProductRequest;
use App\Application\UseCases\Admin\Product\CreateProduct\CreateProductInput;

class FromRequestToCreateInput
{
    public function map(CreateProductRequest $request): CreateProductInput
    {
        return new CreateProductInput(
            $request->validated('price'),
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
