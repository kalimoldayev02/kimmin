<?php

namespace App\Application\UseCases\Admin\Product\GetProducts;

use App\Application\UseCases\Admin\File\DTO\FileOutput;
use App\Application\UseCases\Admin\Product\DTO\GetProductCategoryOutput;
use App\Models\Category;
use App\Models\File;
use App\Repositories\Product\ProductRepository;
use App\Application\UseCases\Admin\Product\DTO\GetProductOutput;

class GetProductsUseCase
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    /**
     * @return GetProductOutput[]
     */
    public function execute(): array
    {
        $result = [];

        foreach ($this->productRepository->getProducts() as $product) {
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

            $result[] = new GetProductOutput(
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


        return $result;
    }
}