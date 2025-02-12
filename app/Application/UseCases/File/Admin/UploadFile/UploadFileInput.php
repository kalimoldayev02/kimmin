<?php

namespace App\Application\UseCases\File\Admin\UploadFile;

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
