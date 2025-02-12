<?php

namespace App\Application\UseCases\Product\Api\GetProductBySlug;

use App\Models\File;
use App\Application\Services\Product\ProductService;

class GetProductBySlugUseCase
{
    public function __construct(private ProductService $productService)
    {
    }

    public function execute(string $slug): ?array
    {
        $product = $this->productService->getProductBySlug($slug, ['files']);

        if (!$product) {
            return null;
        }

        // TODO: надо добавить логику Order|Count

        $files = [];
        /**
         * @var File $file
         */
        foreach ($product->files as $file) {
            $files[] = [$file->path];
        }


        return [
            'id'          => $product->id,
            'slug'        => $product->slug,
            'name'        => $product->name,
            'description' => $product->description,
            'files'       => $files,
        ];
    }
}