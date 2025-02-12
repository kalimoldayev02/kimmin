<?php

namespace App\Application\UseCases\Product\Admin\CreateProduct;

use App\Application\Services\Product\ProductService;

class CreateProductUseCase
{
    public function __construct(private ProductService $productService)
    {
    }

    public function execute(CreateProductInput $input): void
    {
        $this->productService->createProduct([
            'price'    => $input->price,
            'slug'     => $input->slug,
            'file_ids' => $input->fileIds,
            'name' => [
                'ru' => $input->nameRu,
                'kk' => $input->nameKk,
                'en' => $input->nameEn,
            ],
            'description' => [
                'ru' => $input->descriptionRu,
                'kk' => $input->descriptionKk,
                'en' => $input->descriptionEn,
            ],
        ]);
    }
}
