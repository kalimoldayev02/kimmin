<?php

namespace App\Application\UseCases\Admin\Category\DTO;

class FileOutput
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $path,
        public int    $sort
    )
    {
    }
}
