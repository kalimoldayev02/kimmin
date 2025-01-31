<?php

namespace App\Http\Mappers\Admin\Category;

use App\Application\UseCases\Admin\Category\UpdateCategory\UpdateCategoryOutput;

class FromOutputToUpdateCategoryResponse
{
    public function map(UpdateCategoryOutput $output): array
    {
        return ['id' => $output->id];
    }
}