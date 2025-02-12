<?php

namespace App\Http\Controllers\Admin;

use App\Application\UseCases\File\Admin\DeleteFile\DeleteFileUseCase;
use App\Application\UseCases\File\Admin\UploadFile\UploadFileUseCase;
use App\Http\Controllers\Controller;
use App\Http\Mappers\File\FromRequestToDeleteInput as DeleteFileInputMapper;
use App\Http\Mappers\File\FromRequestToUploadInput as UploadFileInputMapper;
use App\Http\Requests\Admin\File\DeleteFileRequest;
use App\Http\Requests\Admin\File\UploadFileRequest;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    #[OA\Post(
        path: '/api/admin/file/upload',
        summary: 'Загрузка файла',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'directory', description: 'Directory', type: 'string', example: 'category'),
                        new OA\Property(
                            property: 'files',
                            description: 'Файлы',
                            type: 'array',
                            items: new OA\Items(type: 'string', format: 'binary')
                        ),
                    ], type: 'object',
                )
            )
        ),
        tags: ['Admin-File'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Successful operation',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'You have successfully uploaded the file'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: 'id', type: 'integer', example: 3),
                                    new OA\Property(property: 'name', type: 'string', example: 'Original Name'),
                                    new OA\Property(property: 'path', type: 'string', example: 'File path'),
                                    new OA\Property(property: 'mime_type', type: 'string', example: 'jpeg'),
                                ]
                            )
                        )
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_BAD_REQUEST,
                description: 'Bad Request',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Houston, we have a problem')
                    ]
                )
            )
        ]
    )]
    public function uploadFiles(
        UploadFileRequest        $request,
        UploadFileUseCase        $useCase,
        UploadFileInputMapper    $inputMapper,
    ): JsonResponse
    {
        try {
            $output = $useCase->execute($inputMapper->map($request));

            return $this->getResponse(true, __('You have successfully uploaded the file'), $output);
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }

    #[OA\Post(
        path: '/api/admin/file/delete',
        summary: 'Удаление файла',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'file_ids', type: 'array', items: new OA\Items(type: 'integer', example: 3))
                ]
            )
        ),
        tags: ['Admin-File'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Successful operation',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', description: 'Статус', type: 'boolean', example: true),
                        new OA\Property(property: 'message', description: 'Сообщение', type: 'string', example: 'You have successfully deleted the file'),
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
    public function deleteFiles(
        DeleteFileRequest     $request,
        DeleteFileUseCase     $useCase,
        DeleteFileInputMapper $inputMapper,
    ): JsonResponse
    {
        try {
            $useCase->execute($inputMapper->map($request));

            return $this->getResponse(true, __('You have successfully deleted the file'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }
}
