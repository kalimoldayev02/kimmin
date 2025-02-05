<?php

namespace App\Application\UseCases\File\DTO;

class FileOutput
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $path,
    )
    {
    }
}
