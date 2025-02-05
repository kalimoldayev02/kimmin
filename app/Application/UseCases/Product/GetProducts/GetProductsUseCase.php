<?php

namespace App\Application\UseCases\Product\GetProducts;

use App\Models\File;
use App\Repositories\Product\ProductRepository;
use App\Application\UseCases\File\DTO\FileOutput;
use App\Application\UseCases\Product\DTO\GetProductOutput;

class GetProductsUseCase
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    /**
     * @return GetProductOutput[]
     */
    public function execute(GetProductsInput $input): array
    {
        $result = [];

        // TODO: надо сделать
        foreach ($this->productRepository->getProducts($input->page * $input->page, $input->limit) as $product) {
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
            );
        }

        return $result;
    }
}
