<?php

namespace App\Http\Controllers\Admin;

use App\Application\UseCases\Admin\Product\CreateProduct\CreateProductUseCase;
use App\Application\UseCases\Admin\Product\UpdateProduct\UpdateProductUseCase;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Admin\Product\FromOutputToCreateResponse as CreateProductResponseMapper;
use App\Http\Mappers\Admin\Product\FromRequestToCreateInput as CreateProductInputMapper;
use App\Http\Requests\Admin\Product\CreateProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    // TODO: добавить Swagger
    public function createProduct(
        CreateProductRequest        $request,
        CreateProductUseCase        $useCase,
        CreateProductInputMapper    $inputMapper,
        CreateProductResponseMapper $responseMapper,
    ): JsonResponse
    {
        try {
            $output = $useCase->execute($inputMapper->map($request));

            return $this->getResponse(true, __('The product has been successfully created'),
                $responseMapper->map($output)
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
