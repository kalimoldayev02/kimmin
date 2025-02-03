<?php

namespace App\Application\UseCases\File\DeleteFile;

class DeleteFileInput
{
    public function __construct(
        public int $id
    )
    {
    }
}