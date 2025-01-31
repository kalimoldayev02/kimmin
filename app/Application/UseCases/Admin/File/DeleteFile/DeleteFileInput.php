<?php

namespace App\Application\UseCases\Admin\File\DeleteFile;

class DeleteFileInput
{
    public function __construct(
        public int $id
    )
    {
    }
}