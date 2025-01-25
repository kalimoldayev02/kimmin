<?php

namespace App\Application\UseCases\Admin\File\UploadFile;

use Illuminate\Http\UploadedFile;

class UploadFileInput
{
    /**
     * @param string $directory
     * @param UploadedFile[] $files
     */
    public function __construct(
        public string $directory,
        public array  $files,
    )
    {
    }
}