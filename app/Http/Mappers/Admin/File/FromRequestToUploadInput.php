<?php

namespace App\Http\Mappers\Admin\File;

use App\Http\Requests\Admin\File\UploadFileRequest;
use App\Application\UseCases\Admin\File\UploadFile\UploadFileInput;

class FromRequestToUploadInput
{
    /**
     * @param UploadFileRequest $request
     * @return UploadFileInput[]
     */
    public function map(UploadFileRequest $request): array
    {
        $result = [];
        foreach ($request->validated('files') as $file) {
            $result[] = new UploadFileInput(
                $request->validated('directory'),
                $file['sort'],
                $file['file'],
            );
        }

        return $result;
    }
}