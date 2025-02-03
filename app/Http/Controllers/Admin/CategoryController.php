<?php

namespace App\Http\Controllers\Admin;

use App\Application\UseCases\Category\CreateCategory\CreateCategoryUseCase;
use App\Application\UseCases\Category\GetCategories\GetCategoriesUseCase;
use App\Application\UseCases\Category\GetCategory\GetCategoryUseCase;
use App\Application\UseCases\Category\UpdateCategory\UpdateCategoryUseCase;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Admin\Category\FromOutputToGetCategoryResponse as GetCategoryResponseMapper;
use App\Http\Mappers\Admin\Category\FromRequestToCreateInput as CreateCategoryInputMapper;
use App\Http\Mappers\Admin\Category\FromRequestToGetCategoryInput as GetCategoryInputMapper;
use App\Http\Mappers\Admin\Category\FromRequestToUpdateCategoryInput as UpdateCategoryInputMapper;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;


class CategoryController extends Controller
{
    #[OA\Post(
        path: '/api/category/create',
        summary: 'Создание категории',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'slug', description: 'Slug', type: 'string', example: 'category-slug'),
                    new OA\Property(property: 'name', description: 'Название', properties: [
                        new OA\Property(property: 'ru', type: 'string', example: 'Name RU'),
                        new OA\Property(property: 'kk', type: 'string', example: 'Name KK'),
                        new OA\Property(property: 'en', type: 'string', example: 'Name EN')
                    ], type: 'object'),
                ]
            )
        ),
        tags: ['Admin-Category'],
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
    public function createCategory(
        CreateCategoryRequest     $request,
        CreateCategoryUseCase     $useCase,
        CreateCategoryInputMapper $inputMapper,
    ): JsonResponse
    {
        try {
            $useCase->execute($inputMapper->map($request));

            return $this->getResponse(true, __('The category has been successfully created'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }

    #[OA\Post(
        path: '/api/category/{category}/update',
        summary: 'Редактирование категории',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', description: 'Название', properties: [
                        new OA\Property(property: 'ru', type: 'string', example: 'Name RU'),
                        new OA\Property(property: 'kk', type: 'string', example: 'Name KK'),
                        new OA\Property(property: 'en', type: 'string', example: 'Name EN')
                    ], type: 'object'),
                    new OA\Property(property: 'slug', description: 'Slug', type: 'string', example: 'category-slug'),
                ]
            )
        ),
        tags: ['Admin-Category'],
        parameters: [
            new OA\Parameter(
                name: 'category',
                description: 'Идентификатор категории',
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
    public function updateCategory(
        int                       $categoryId,
        UpdateCategoryRequest     $request,
        UpdateCategoryUseCase     $useCase,
        UpdateCategoryInputMapper $inputMapper,
    ): JsonResponse
    {
        try {
            $useCase->execute($inputMapper->map($categoryId, $request));

            return $this->getResponse(true, __('The category has been successfully updated'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }

    #[OA\Get(
        path: '/api/category/{category}',
        summary: 'Получение категории',
        tags: ['Admin-Category'],
        parameters: [
            new OA\Parameter(
                name: 'category',
                description: 'Идентификатор категории',
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
                                new OA\Property(property: 'slug', type: 'string', example: 'category-slug'),
                                new OA\Property(
                                    property: 'name',
                                    properties: [
                                        new OA\Property(property: 'ru', type: 'string', example: 'Name RU'),
                                        new OA\Property(property: 'kk', type: 'string', example: 'Name KK'),
                                        new OA\Property(property: 'en', type: 'string', example: 'Name EN'),
                                    ],
                                    type: 'object'
                                )
                            ],
                            type: 'object'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: 'Категория не найдена',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Category not found')
                    ]
                )
            )
        ]
    )]
    public function getCategory(
        int                       $categoryId,
        GetCategoryUseCase        $useCase,
        GetCategoryInputMapper    $inputMapper,
        GetCategoryResponseMapper $responseMapper,
    ): JsonResponse
    {
        try {
            if ($output = $useCase->execute($inputMapper->map($categoryId))) {
                return $this->getResponse(true, '', $responseMapper->map($output));
            }

            return $this->getResponse(false, __('Category not found'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }

    #[OA\Get(
        path: '/api/category/list',
        summary: 'Получение всех категорий',
        tags: ['Admin-Category'],
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
                            type: 'array',
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: 'id', type: 'integer', example: 3),
                                    new OA\Property(property: 'slug', type: 'string', example: 'category-slug'),
                                    new OA\Property(
                                        property: 'name',
                                        properties: [
                                            new OA\Property(property: 'ru', type: 'string', example: 'Name RU'),
                                            new OA\Property(property: 'kk', type: 'string', example: 'Name KK'),
                                            new OA\Property(property: 'en', type: 'string', example: 'Name EN'),
                                        ],
                                        type: 'object'
                                    )
                                ]
                            )
                        )
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: 'Категории не найдены',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Categories not found')
                    ]
                )
            )
        ]
    )]
    public function getCategories(
        Request                   $request,
        GetCategoriesUseCase      $useCase,
        GetCategoryResponseMapper $responseMapper,
    ): JsonResponse
    {
        dd([
            'limit' => $request->query(),
        ]);
        try {
            if ($outputs = $useCase->execute()) {
                $responseData = [];
                foreach ($outputs as $output) {
                    $responseData[] = $responseMapper->map($output);
                }

                return $this->getResponse(true, '', $responseData);
            }

            return $this->getResponse(false, __('Categories not found'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }
}
