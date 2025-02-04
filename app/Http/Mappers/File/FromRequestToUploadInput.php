<?php

namespace App\Http\Mappers\File;

use App\Application\UseCases\File\UploadFile\UploadFileInput;
use App\Http\Requests\Admin\File\UploadFileRequest;

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
                $file,
            );
        }

        return $result;
    }
}