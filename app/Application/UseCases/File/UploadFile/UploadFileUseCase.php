<?php

namespace App\Application\UseCases\File\UploadFile;

use App\Application\Services\File\FileService;

class UploadFileUseCase
{
    public function __construct(private FileService $fileService)
    {
    }

    public function execute(array $inputs): array
    {
        $result = [];

        foreach ($inputs as $input) {
            $file = $this->fileService->uploadFile($input);

            $result[] = [
                'id'        => $file->id,
                'path'      => $file->path,
                'name'      => $file->name,
                'mime_type' => $file->mime_type,
            ];
        }

        return $result;
    }
}
