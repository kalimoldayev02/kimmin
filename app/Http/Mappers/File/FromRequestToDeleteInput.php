<?php

namespace App\Http\Mappers\File;

use App\Application\UseCases\File\Admin\DeleteFile\DeleteFileInput;
use App\Http\Requests\Admin\File\DeleteFileRequest;

class FromRequestToDeleteInput
{
    /**
     * @param DeleteFileRequest $request
     * @return DeleteFileInput[]
     */
    public function map(DeleteFileRequest $request): array
    {
        $result = [];
        foreach ($request->validated('file_ids') as $fileId) {
            $result[] = new DeleteFileInput($fileId);
        }

        return $result;
    }
}