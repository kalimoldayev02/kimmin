<?php

namespace App\Application\UseCases\File\Admin\DeleteFile;

class DeleteFileInput
{
    public function __construct(
        public int $id
    )
    {
    }
}