<?php

namespace App\Http\Mappers\Admin\Product;

use App\Application\UseCases\Product\DTO\GetProductOutput;

class FromOutputToGetProductResponse
{
    public function map(GetProductOutput $output): array
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

        $categories = [];
        foreach ($output->categories as $category) {
            $categories[] = [
                'id'   => $category->id,
                'slug' => $category->slug,
                'name_ru' => $category->nameRu,
                'name_kk' => $category->nameKk,
                'name_en' => $category->nameEn,
            ];
        }

        return [
            'id'             => $output->id,
            'price'          => $output->price,
            'slug'           => $output->slug,
            'name_ru'        => $output->nameRu,
            'name_kk'        => $output->nameKk,
            'name_en'        => $output->nameEn,
            'description_ru' => $output->descriptionRu,
            'description_kk' => $output->descriptionKk,
            'description_en' => $output->descriptionEn,
            'files'          => $files,
            'categories'     => $categories,
        ];
    }
}