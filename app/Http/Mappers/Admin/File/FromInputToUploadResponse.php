<?php

namespace App\Http\Mappers\Admin\File;

use App\Application\UseCases\File\UploadFile\UploadFileOutput;

class FromInputToUploadResponse
{
    public function map(UploadFileOutput $output): array
    {
        return [
            'id'   => $output->id,
            'name' => $output->name,
            'path' => $output->path,
        ];
    }
}