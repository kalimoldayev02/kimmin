<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CreateProductRequest;
use App\Http\Mappers\Admin\Product\FromRequestToCreateInput as CreateProductMapper;
use App\Application\UseCases\Admin\Product\CreateProduct\CreateProductUseCase;

class ProductController extends Controller
{
    // TODO: добавить Swagger
    public function createProduct(
        CreateProductRequest $request,
        CreateProductUseCase $useCase,
        CreateProductMapper  $mapper,
    ): JsonResponse
    {
        try {
            $output = $useCase->execute($mapper->map($request));

            return $this->getResponse(true, __('The product has been successfully created'),
                ['id' => $output->id]
            );
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }
}
