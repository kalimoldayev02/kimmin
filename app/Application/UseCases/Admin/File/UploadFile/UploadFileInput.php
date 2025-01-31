<?php

namespace App\Application\UseCases\Admin\File\UploadFile;

use Illuminate\Http\UploadedFile;

class UploadFileInput
{
    /**
     * @param string $directory
     * @param int $sort
     * @param UploadedFile $file
     */
    public function __construct(
        public string $directory,
        public int    $sort,
        public UploadedFile $file
    )
    {
    }
}