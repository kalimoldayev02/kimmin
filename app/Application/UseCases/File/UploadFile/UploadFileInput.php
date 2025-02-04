<?php

namespace App\Application\UseCases\File\UploadFile;

use Illuminate\Http\UploadedFile;

class UploadFileInput
{
    /**
     * @param string $directory
     * @param UploadedFile $file
     */
    public function __construct(
        public string       $directory,
        public UploadedFile $file
    )
    {
    }
}
