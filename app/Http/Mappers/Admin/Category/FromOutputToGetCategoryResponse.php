<?php

namespace App\Http\Mappers\Admin\Category;

use App\Application\UseCases\Admin\Category\DTO\GetCategoryOutput;

class FromOutputToGetCategoryResponse
{
    public function map(GetCategoryOutput $output): array
    {
        $files = [];
        foreach ($output->files as $file) {
            $files[] = [
                'id'   => $file->id,
                'sort' => $file->sort,
                'name' => $file->name,
                'path' => $file->path,
            ];
        }

        return [
            'id'      => $output->id,
            'name_ru' => $output->nameRu,
            'name_kk' => $output->nameKk,
            'name_en' => $output->nameEn,
            'slug'    => $output->slug,
            'files'   => $files,
        ];
    }
}
