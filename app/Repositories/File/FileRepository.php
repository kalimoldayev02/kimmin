<?php

namespace App\Repositories\File;

use App\Models\File;

class FileRepository
{
    public function __construct(private File $fileModel)
    {
    }

    public function create(array $data): File
    {
        return $this->fileModel->create([
            'name'      => $data['name'],
            'path'      => $data['path'],
            'mime_type' => $data['mime_type'],
        ]);
    }

    public function delete(int $fileId): void
    {
        $file = $this->fileModel->find($fileId);
        $file?->delete();
    }

    public function getFileById(int $fileId): ?File
    {
        return $this->fileModel->find($fileId);
    }

    public function getFilesByIds(array $fileIds): array
    {

    }
}
