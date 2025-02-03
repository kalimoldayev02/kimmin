<?php

namespace App\Http\Controllers\Admin;

use App\Application\UseCases\File\DeleteFile\DeleteFileUseCase;
use App\Application\UseCases\File\UploadFile\UploadFileUseCase;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Admin\File\FromInputToUploadResponse as UploadFileResponseMapper;
use App\Http\Mappers\Admin\File\FromRequestToDeleteInput as DeleteFileInputMapper;
use App\Http\Mappers\Admin\File\FromRequestToUploadInput as UploadFileInputMapper;
use App\Http\Requests\Admin\File\DeleteFileRequest;
use App\Http\Requests\Admin\File\UploadFileRequest;
use Illuminate\Http\JsonResponse;

class FileController extends Controller
{
    // TODO: добавить Swagger
    public function uploadFiles(
        UploadFileRequest        $request,
        UploadFileUseCase        $useCase,
        UploadFileInputMapper    $inputMapper,
        UploadFileResponseMapper $responseMapper,
    ): JsonResponse
    {
        try {
            $responseData = [];
            $outputs = $useCase->execute($inputMapper->map($request));

            foreach ($outputs as $output) {
                $responseData[] = $responseMapper->map($output);
            }

            return $this->getResponse(true, __('You have successfully uploaded the file'), $responseData);
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }

    // TODO: добавить Swagger
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
