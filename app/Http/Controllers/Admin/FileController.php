<?php

namespace App\Http\Controllers\Admin;

use App\Application\UseCases\Admin\File\DeleteFile\DeleteFileUseCase;
use App\Application\UseCases\Admin\File\UploadFile\UploadFileUseCase;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Admin\File\FromRequestToDeleteInput as DeleteFileMapper;
use App\Http\Mappers\Admin\File\FromRequestToUploadInput as UploadFileMapper;
use App\Http\Requests\Admin\File\DeleteFileRequest;
use App\Http\Requests\Admin\File\UploadFileRequest;

class FileController extends Controller
{
    // TODO: добавить Swagger
    public function upload(
        UploadFileRequest $request,
        UploadFileMapper  $mapper,
        UploadFileUseCase $useCase,
    )
    {
        try {
            $responseData = [];
            $output = $useCase->execute($mapper->map($request));

            foreach ($output as $item) {
                $responseData[] = [
                    'id'   => $item->id,
                    'name' => $item->name,
                    'path' => $item->path,
                ];
            }

            return $this->getResponse(true, __('You have successfully uploaded the file'), $responseData);
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }

    // TODO: добавить Swagger
    public function delete(
        DeleteFileRequest $request,
        DeleteFileMapper  $mapper,
        DeleteFileUseCase $useCase,
    )
    {
        try {
            $useCase->execute($mapper->map($request));

            return $this->getResponse(true, __('You have successfully deleted the file'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }
}
