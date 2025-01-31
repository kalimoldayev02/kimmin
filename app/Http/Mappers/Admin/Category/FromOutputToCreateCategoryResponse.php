<?php

namespace App\Http\Mappers\Admin\Category;

use App\Application\UseCases\Admin\Category\CreateCategory\CreateCategoryOutput;

class FromOutputToCreateCategoryResponse
{
    public function map(CreateCategoryOutput $output): array
    {
        return ['id' => $output->id];
    }
}