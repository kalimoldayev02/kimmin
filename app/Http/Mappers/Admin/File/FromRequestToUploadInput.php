<?php

namespace App\Http\Mappers\Admin\File;

use App\Http\Requests\Admin\File\UploadFileRequest;
use App\Application\UseCases\Admin\File\UploadFile\UploadFileInput;

class FromRequestToUploadInput
{
    public function map(UploadFileRequest $request)
    {
        return new UploadFileInput(
            $request->validated('directory'),
            $request->validated('files'),
        );
    }
}