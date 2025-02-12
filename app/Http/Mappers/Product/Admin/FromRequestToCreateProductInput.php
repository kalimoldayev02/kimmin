<?php

namespace App\Http\Mappers\Product\Admin;

use App\Application\UseCases\Product\Admin\CreateProduct\CreateProductInput;
use App\Http\Requests\Admin\Product\CreateProductRequest;

class FromRequestToCreateProductInput
{
    public function map(CreateProductRequest $request): CreateProductInput
    {
        return new CreateProductInput(
            $request->validated('price'),
            $request->validated('slug'),
            $request->validated('name.ru'),
            $request->validated('name.kk'),
            $request->validated('name.en'),
            $request->validated('description.ru'),
            $request->validated('description.kk'),
            $request->validated('description.en'),
            $request->validated('file_ids'),
        );
    }
}
