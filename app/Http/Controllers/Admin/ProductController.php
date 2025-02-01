<?php

namespace App\Http\Controllers\Admin;

use App\Application\UseCases\Admin\Product\CreateProduct\CreateProductUseCase;
use App\Application\UseCases\Admin\Product\GetProduct\GetProductUseCase;
use App\Application\UseCases\Admin\Product\GetProducts\GetProductsUseCase;
use App\Application\UseCases\Admin\Product\UpdateProduct\UpdateProductUseCase;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Admin\Product\FromOutputToCreateProductResponse as CreateProductResponseMapper;
use App\Http\Mappers\Admin\Product\FromOutputToGetProductResponse as GetProductResponseMapper;
use App\Http\Mappers\Admin\Product\FromOutputToUpdateProductResponse as UpdateProductResponseMapper;
use App\Http\Mappers\Admin\Product\FromRequestToCreateProductInput as CreateProductInputMapper;
use App\Http\Mappers\Admin\Product\FromRequestToGetProductInput as GetProductInputMapper;
use App\Http\Mappers\Admin\Product\FromRequestToUpdateProductInput as UpdateProductInputMapper;
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

    // TODO: добавить Swagger
    public function updateProduct(
        int                         $productId,
        UpdateProductRequest        $request,
        UpdateProductUseCase        $useCase,
        UpdateProductInputMapper    $inputMapper,
        UpdateProductResponseMapper $responseMapper,
    ): JsonResponse
    {
        try {
            $output = $useCase->execute($inputMapper->map($productId, $request));

            return $this->getResponse(true, __('The product has been successfully updated'),
                $responseMapper->map($output)
            );
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }

    // TODO: добавить Swagger
    public function getProduct(
        int                      $productId,
        GetProductUseCase        $useCase,
        GetProductInputMapper    $inputMapper,
        GetProductResponseMapper $responseMapper,
    ): JsonResponse
    {
        try {
            $output = $useCase->execute($inputMapper->map($productId));

            return $this->getResponse(true, '', $responseMapper->map($output));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }

    // TODO: добавить Swagger
    public function getProducts(
        GetProductsUseCase       $useCase,
        GetProductResponseMapper $responseMapper,
    ): JsonResponse
    {
        try {
            $responseData = [];
            $outputs = $useCase->execute();

            foreach ($outputs as $output) {
                $responseData[] = $responseMapper->map($output);
            }

            return $this->getResponse(true, '', $responseData);
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }
}
