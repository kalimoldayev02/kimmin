<?php

namespace App\Http\Controllers\Admin;

use OpenApi\Attributes as OA;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Http\Requests\Admin\Product\CreateProductRequest;
use App\Application\UseCases\Product\GetProduct\GetProductUseCase;
use App\Application\UseCases\Product\GetProducts\GetProductsUseCase;
use App\Application\UseCases\Product\UpdateProduct\UpdateProductUseCase;
use App\Application\UseCases\Product\CreateProduct\CreateProductUseCase;
use App\Http\Mappers\Admin\Product\FromRequestToGetProductInput as GetProductInputMapper;
use App\Http\Mappers\Admin\Product\FromOutputToGetProductResponse as GetProductResponseMapper;
use App\Http\Mappers\Admin\Product\FromRequestToCreateProductInput as CreateProductInputMapper;
use App\Http\Mappers\Admin\Product\FromRequestToUpdateProductInput as UpdateProductInputMapper;

class ProductController extends Controller
{
    #[OA\Post(
        path: '/api/admin/product/create',
        summary: 'Создание продукта',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'slug', description: 'Slug', type: 'string', example: 'product-slug'),
                    new OA\Property(property: 'price', description: 'Price', type: 'integer', example: 10),
                    new OA\Property(property: 'file_ids', type: 'array', items: new OA\Items(type: 'integer', example: 3)),
                    new OA\Property(property: 'name', description: 'Название', properties: [
                        new OA\Property(property: 'ru', type: 'string', example: 'Name RU'),
                        new OA\Property(property: 'kk', type: 'string', example: 'Name KK'),
                        new OA\Property(property: 'en', type: 'string', example: 'Name EN')
                    ], type: 'object'),
                    new OA\Property(property: 'description', description: 'Описание', properties: [
                        new OA\Property(property: 'ru', type: 'string', example: 'Desc RU'),
                        new OA\Property(property: 'kk', type: 'string', example: 'Desc KK'),
                        new OA\Property(property: 'en', type: 'string', example: 'Desc EN')
                    ], type: 'object'),
                ]
            )
        ),
        tags: ['Admin-Product'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Successful operation',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', description: 'Статус', type: 'boolean', example: true),
                        new OA\Property(property: 'message', description: 'Сообщение', type: 'string', example: 'The category has been successfully created'),
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_BAD_REQUEST,
                description: 'Bad Request',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', description: 'Operation\'s status', type: 'boolean', example: false),
                        new OA\Property(property: 'message', description: 'Сообщение', type: 'string', example: 'The given data was invalid'),
                        new OA\Property(property: 'errors', properties: [
                            new OA\Property(property: 'slug', type: 'array', items: new OA\Items(type: 'string', example: 'Houston, we have a problem'))
                        ], type: 'object'),
                    ]
                )
            ),
        ]
    )]
    public function createProduct(
        CreateProductRequest        $request,
        CreateProductUseCase        $useCase,
        CreateProductInputMapper    $inputMapper,
    ): JsonResponse
    {
        try {
            $useCase->execute($inputMapper->map($request));

            return $this->getResponse(true, __('The product has been successfully created'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }

    #[OA\Post(
        path: '/api/admin/product/{product}/update',
        summary: 'Редактирование продукта',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'slug', description: 'Slug', type: 'string', example: 'product-slug'),
                    new OA\Property(property: 'price', description: 'Price', type: 'integer', example: 10),
                    new OA\Property(property: 'file_ids', type: 'array', items: new OA\Items(type: 'integer', example: 3)),
                    new OA\Property(property: 'name', description: 'Название', properties: [
                        new OA\Property(property: 'ru', type: 'string', example: 'Name RU'),
                        new OA\Property(property: 'kk', type: 'string', example: 'Name KK'),
                        new OA\Property(property: 'en', type: 'string', example: 'Name EN')
                    ], type: 'object'),
                    new OA\Property(property: 'description', description: 'Описание', properties: [
                        new OA\Property(property: 'ru', type: 'string', example: 'Desc RU'),
                        new OA\Property(property: 'kk', type: 'string', example: 'Desc KK'),
                        new OA\Property(property: 'en', type: 'string', example: 'Desc EN')
                    ], type: 'object'),
                ]
            )
        ),
        tags: ['Admin-Product'],
        parameters: [
            new OA\Parameter(
                name: 'product',
                description: 'Идентификатор продукта',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string')
            )
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Successful operation',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', description: 'Статус', type: 'boolean', example: true),
                        new OA\Property(property: 'message', description: 'Сообщение', type: 'string', example: 'The category has been successfully updated'),
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_BAD_REQUEST,
                description: 'Bad Request',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', description: 'Operation\'s status', type: 'boolean', example: false),
                        new OA\Property(property: 'message', description: 'Сообщение', type: 'string', example: 'The given data was invalid'),
                        new OA\Property(property: 'errors', properties: [
                            new OA\Property(property: 'slug', type: 'array', items: new OA\Items(type: 'string', example: 'Houston, we have a problem'))
                        ], type: 'object'),
                    ]
                )
            ),
        ]
    )]
    public function updateProduct(
        int                         $productId,
        UpdateProductRequest        $request,
        UpdateProductUseCase        $useCase,
        UpdateProductInputMapper    $inputMapper,
    ): JsonResponse
    {
        try {
            $useCase->execute($inputMapper->map($productId, $request));

            return $this->getResponse(true, __('The product has been successfully updated'));
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
