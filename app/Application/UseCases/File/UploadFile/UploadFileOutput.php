<?php

namespace App\Application\UseCases\File\UploadFile;

class UploadFileOutput
{
    public function __construct(
        public int    $id,
        public string $path,
        public string $name
    )
    {
    }
}
