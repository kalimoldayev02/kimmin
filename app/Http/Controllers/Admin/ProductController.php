<?php

namespace App\Http\Controllers\Admin;

use App\Application\UseCases\Admin\Product\CreateProduct\CreateProductUseCase;
use App\Application\UseCases\Admin\Product\UpdateProduct\UpdateProductUseCase;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Admin\Product\FromRequestToCreateInput as CreateProductMapper;
use App\Http\Requests\Admin\Product\CreateProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use Illuminate\Http\JsonResponse;

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

    public function updateProduct(
        int                  $productId,
        UpdateProductRequest $request,
        UpdateProductUseCase $useCase,
    ): JsonResponse
    {

    }
}
