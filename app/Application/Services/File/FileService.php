<?php

namespace App\Application\Services\File;

use App\Application\UseCases\File\UploadFile\UploadFileInput;
use App\Events\File\FileDeleted;
use App\Models\File;
use App\Repositories\File\FileRepository;
use function event;

class FileService
{
    public function __construct(private FileRepository $fileRepository)
    {
    }

    public function uploadFile(UploadFileInput $input): File
    {
        $fileMimeType = $input->file->getClientOriginalExtension();
        $fileName = sprintf('%s-%s.%s', uniqid(), time(), $fileMimeType);
        $filePath = $input->file->storeAs($input->directory, $fileName, 'public');

        return $this->fileRepository->create([
            'name'      => $input->file->getClientOriginalName(),
            'path'      => $filePath,
            'mime_type' => $fileMimeType,
        ]);
    }

    public function deleteFiles(array $fileIds): void
    {
        $filePaths = [];

        foreach ($fileIds as $fileId) {
            if ($file = $this->fileRepository->getFileById($fileId)) {
                if ($file->products()->count()) {
                    continue;
                }

                $filePaths[] = $file->path;
                $this->fileRepository->delete($fileId);
            }
        }

        if ($filePaths) {
            event(new FileDeleted($filePaths));
        }
    }
}
