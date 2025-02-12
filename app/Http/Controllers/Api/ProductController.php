<?php

namespace App\Http\Controllers\Api;

use App\Application\UseCases\Product\Api\GetProductBySlug\GetProductBySlugUseCase;
use App\Application\UseCases\Product\Api\GetProducts\GetProductsUseCase;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Product\Api\FromRequestToGetProductsInput as GetProductsInputMapper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProducts(
        Request                $request,
        GetProductsUseCase     $useCase,
        GetProductsInputMapper $inputMapper,
    ): JsonResponse
    {
        try {
            if ($output = $useCase->execute($inputMapper->map($request))) {

                return $this->getResponse(true, '', $output);
            }

            return $this->getResponse(false, __('Products not found'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }

    public function getProductBySlug(
        string                  $slug,
        GetProductBySlugUseCase $useCase,
    ): JsonResponse
    {
        try {
            if ($output = $useCase->execute($slug)) {

                return $this->getResponse(true, '', $output);
            }

            return $this->getResponse(false, __('Product not found'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }
}
