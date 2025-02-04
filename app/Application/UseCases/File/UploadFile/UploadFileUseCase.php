<?php

namespace App\Application\UseCases\File\UploadFile;

use App\Services\File\FileService;

class UploadFileUseCase
{
    public function __construct(private FileService $fileService)
    {
    }

    /**
     * @param UploadFileInput[] $inputs
     * @return UploadFileOutput[]
     */
    public function execute(array $inputs): array
    {
        $result = [];

        foreach ($inputs as $input) {
            $file = $this->fileService->uploadFile($input);

            $result[] = new UploadFileOutput($file->id, $file->path, $file->name);
        }

        return $result;
    }
}
