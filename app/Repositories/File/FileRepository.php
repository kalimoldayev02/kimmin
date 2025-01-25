<?php

namespace App\Repositories\File;

use App\Models\File;

class FileRepository
{
    public function create(array $data): File
    {
        $file = File::create([
            'name' => $data['name'],
            'mime_type' => $data['mime_type'],
            'path' => $data['path'],
        ]);

        return $file;
    }

    public function delete(int $fileId): void
    {
        $file = File::find($fileId);
        $file->delete();
    }

    public function getFileById(int $id): ?File
    {
        return File::find($id);
    }
}