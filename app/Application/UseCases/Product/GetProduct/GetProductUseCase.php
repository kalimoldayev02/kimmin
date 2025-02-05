<?php

namespace App\Application\UseCases\Product\GetProduct;

use App\Models\File;
use App\Services\Product\ProductService;
use App\Application\UseCases\File\DTO\FileOutput;
use App\Application\UseCases\Product\DTO\GetProductOutput;

class GetProductUseCase
{
    public function __construct(private ProductService $productService)
    {
    }

    public function execute(GetProductInput $input): ?GetProductOutput
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
            $files[] = new FileOutput(
                $file->id,
                $file->name,
                $file->path,
            );
        }

        return new GetProductOutput(
            $product->id,
            $product->getTranslation('name', 'ru'),
            $product->getTranslation('name', 'kk'),
            $product->getTranslation('name', 'en'),
            $product->getTranslation('description', 'ru'),
            $product->getTranslation('description', 'kk'),
            $product->getTranslation('description', 'en'),
            $product->slug,
            $product->price,
            $files,
        );
    }
}