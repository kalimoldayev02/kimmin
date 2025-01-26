<?php

namespace App\Application\UseCases\Admin\File\UploadFile;

class UploadFileOutput
{
    public function __construct(
        public int    $id,
        public string $path,
        public string $name,
    )
    {
    }
}