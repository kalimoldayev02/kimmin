<?php

namespace App\Application\UseCases\File\Admin\DeleteFile;

use App\Application\Services\File\FileService;

class DeleteFileUseCase
{
    public function __construct(private FileService $fileService)
    {
    }

    /**
     * @param DeleteFileInput[] $inputs
     * @return void
     */
    public function execute(array $inputs): void
    {
        $fileIds = [];
        foreach ($inputs as $input) {
            $fileIds[] = $input->id;
        }

        $this->fileService->deleteFiles($fileIds);
    }
}