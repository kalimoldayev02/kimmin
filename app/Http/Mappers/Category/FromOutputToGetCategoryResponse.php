<?php

namespace App\Http\Mappers\Category;

use App\Application\UseCases\Category\DTO\GetCategoryOutput;

class FromOutputToGetCategoryResponse
{
    public function map(GetCategoryOutput $output): array
    {
        return [
            'id'   => $output->id,
            'slug' => $output->slug,
            'name' => [
                'ru' => $output->nameRu,
                'kk' => $output->nameKk,
                'en' => $output->nameEn,
            ],
        ];
    }
}
