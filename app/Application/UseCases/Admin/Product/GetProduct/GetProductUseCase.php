<?php

namespace App\Application\UseCases\Admin\Product\GetProduct;

use App\Application\UseCases\Admin\File\DTO\FileOutput;
use App\Application\UseCases\Admin\Product\DTO\GetProductCategoryOutput;
use App\Application\UseCases\Admin\Product\DTO\GetProductOutput;
use App\Models\Category;
use App\Models\File;
use App\Repositories\Product\ProductRepository;

class GetProductUseCase
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function execute(GetProductInput $input): ?GetProductOutput
    {
        $product = $this->productRepository->getProductById($input->id);

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
                $file->sort
            );
        }

        $categories = [];
        /**
         * @var Category $category
         */
        foreach ($product->categories as $category) {
            $categories[] = new GetProductCategoryOutput(
                $category->id,
                $category->getTranslation('name', 'ru'),
                $category->getTranslation('name', 'kk'),
                $category->getTranslation('name', 'en'),
                $category->slug
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
            $categories
        );
    }
}