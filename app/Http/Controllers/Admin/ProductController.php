<?php

namespace App\Http\Controllers\Admin;

use App\Application\UseCases\Product\CreateProduct\CreateProductUseCase;
use App\Application\UseCases\Product\GetProduct\GetProductUseCase;
use App\Application\UseCases\Product\GetProducts\GetProductsUseCase;
use App\Application\UseCases\Product\UpdateProduct\UpdateProductUseCase;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Product\FromOutputToGetProductResponse as GetProductResponseMapper;
use App\Http\Mappers\Product\FromRequestToCreateProductInput as CreateProductInputMapper;
use App\Http\Mappers\Product\FromRequestToGetProductInput as GetProductInputMapper;
use App\Http\Mappers\Product\FromRequestToGetProductsInput as GetProductsInputMapper;
use App\Http\Mappers\Product\FromRequestToUpdateProductInput as UpdateProductInputMapper;
use App\Http\Requests\Admin\Product\CreateProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

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

    #[OA\Get(
        path: '/api/admin/product/{product}',
        summary: 'Получение продукта',
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
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: ''),
                        new OA\Property(
                            property: 'data',
                            properties: [
                                new OA\Property(property: 'id', type: 'integer', example: 3),
                                new OA\Property(property: 'price', type: 'string', example: 10),
                                new OA\Property(property: 'slug', type: 'string', example: 'category-slug'),
                                new OA\Property(
                                    property: 'name',
                                    properties: [
                                        new OA\Property(property: 'ru', type: 'string', example: 'Name RU'),
                                        new OA\Property(property: 'kk', type: 'string', example: 'Name KK'),
                                        new OA\Property(property: 'en', type: 'string', example: 'Name EN'),
                                    ],
                                    type: 'object'
                                ),
                                new OA\Property(
                                    property: 'description',
                                    properties: [
                                        new OA\Property(property: 'ru', type: 'string', example: 'Desc RU'),
                                        new OA\Property(property: 'kk', type: 'string', example: 'Desc KK'),
                                        new OA\Property(property: 'en', type: 'string', example: 'Desc EN'),
                                    ],
                                    type: 'object'
                                ),
                                new OA\Property(
                                    property: 'files',
                                    type: 'array',
                                    items: new OA\Items(
                                        properties: [
                                            new OA\Property(property: 'id', type: 'integer', example: 3),
                                            new OA\Property(property: 'name', type: 'string', example: 'Original Name'),
                                            new OA\Property(property: 'path', type: 'string', example: 'File path'),
                                        ]
                                    )
                                )
                            ],
                            type: 'object'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: 'Продукт не найден',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Product not found')
                    ]
                )
            )
        ]
    )]
    public function getProduct(
        int                      $productId,
        GetProductUseCase        $useCase,
        GetProductInputMapper    $inputMapper,
        GetProductResponseMapper $responseMapper,
    ): JsonResponse
    {
        try {
            if ($output = $useCase->execute($inputMapper->map($productId))) {
                return $this->getResponse(true, '', $responseMapper->map($output));
            }

            return $this->getResponse(false, __('Product not found'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }

    // TODO: добавить Swagger
    public function getProducts(
        Request                  $request,
        GetProductsUseCase       $useCase,
        GetProductsInputMapper   $inputMapper,
        GetProductResponseMapper $responseMapper,
    ): JsonResponse
    {
        try {
            if ($outputs = $useCase->execute($inputMapper->map($request))) {
                $responseData = [];
                foreach ($outputs as $output) {
                    $responseData[] = $responseMapper->map($output);
                }

                return $this->getResponse(true, '', $responseData);
            }

            return $this->getResponse(false, __('Products not found'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }
}
