<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class SlugController extends Controller
{
    #[OA\Post(
        path: '/api/admin/slug',
        summary: 'Генерация slug',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'value', description: 'Value for slug', type: 'string', example: 'category'),
                ]
            )
        ),
        tags: ['Admin-Slug'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Successful operation',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', description: 'Статус', type: 'boolean', example: true),
                        new OA\Property(property: 'message', description: 'Сообщение', type: 'string', example: ''),
                        new OA\Property(
                            property: 'data',
                            properties: [new OA\Property(property: 'slug', type: 'string', example: 'category-slug')],
                            type: 'object'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_BAD_REQUEST,
                description: 'Bad Request',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', description: 'Operation\'s status', type: 'boolean', example: false),
                        new OA\Property(property: 'message', description: 'Сообщение', type: 'string', example: 'Houston, we have a problem'),
                    ]
                )
            ),
        ]
    )]
    public function generateSlug(
        Request $request,
    ): JsonResponse
    {
        try {
            $request->validate(['value' => ['required', 'string', 'min:3']]);

            return $this->getResponse(true, '', ['slug' => Str::slug($request->value)]);
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }
}
