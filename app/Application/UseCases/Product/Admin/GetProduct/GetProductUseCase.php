<?php

namespace App\Application\UseCases\Product\Admin\GetProduct;

use App\Application\Services\Product\ProductService;
use App\Models\File;

class GetProductUseCase
{
    public function __construct(private ProductService $productService)
    {
    }

    public function execute(GetProductInput $input): ?array
    {
        $product = $this->productService->getProductById($input->id);

        if (!$product) {
            return null;
        }

        $files = [];
        /**
         * @var File $file
         */
        foreach ($product->files as $file) {
            $files[] = [
                'id'        => $file->id,
                'name'      => $file->name,
                'path'      => $file->path,
                'mime_type' => $file->mime_type
            ];
        }

        return [
            'id'   => $product->id,
            'slug' => $product->slug,
            'name' => [
                'ru' => $product->getTranslation('name', 'ru'),
                'kk' => $product->getTranslation('name', 'kk'),
                'en' => $product->getTranslation('name', 'en'),
            ],
            'description' => [
                'ru' => $product->getTranslation('description', 'ru'),
                'kk' => $product->getTranslation('description', 'kk'),
                'en' => $product->getTranslation('description', 'en'),
            ],
            'files' => $files,
        ];
    }
}