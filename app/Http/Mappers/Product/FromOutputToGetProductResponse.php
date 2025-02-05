<?php

namespace App\Http\Mappers\Product;

use App\Application\UseCases\Product\DTO\GetProductOutput;

class FromOutputToGetProductResponse
{
    public function map(GetProductOutput $output): array
    {
        $files = [];
        foreach ($output->files as $file) {
            $files[] = [
                'id'   => $file->id,
                'name' => $file->name,
                'path' => $file->path,
            ];
        }

        return [
            'id'    => $output->id,
            'price' => $output->price,
            'slug'  => $output->slug,
            'name' => [
                'ru' => $output->nameRu,
                'kk' => $output->nameKk,
                'en' => $output->nameEn,
            ],
            'description' => [
                'ru' => $output->descriptionRu,
                'kk' => $output->descriptionKk,
                'en' => $output->descriptionEn,
            ],
            'files' => $files,
        ];
    }
}