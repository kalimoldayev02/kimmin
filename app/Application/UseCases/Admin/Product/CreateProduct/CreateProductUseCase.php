<?php

namespace App\Application\UseCases\Admin\Product\CreateProduct;

use Illuminate\Support\Str;
use App\Repositories\Product\ProductRepository;

class CreateProductUseCase
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function execute(CreateProductInput $input): CreateProductOutput
    {
        $name = [
            'ru' => $input->nameRu,
            'kk' => $input->nameKk,
            'en' => $input->nameEn,
        ];
        $description = [
            'ru' => $input->descriptionRu,
            'kk' => $input->descriptionKk,
            'en' => $input->descriptionEn,
        ];

        $product = $this->productRepository->create([
            'name'         => $name,
            'description'  => $description,
            'slug'         => Str::slug($input->nameRu),
            'file_ids'     => $input->fileIds,
            'category_ids' => $input->categoryIds,
        ]);

        return new CreateProductOutput($product->id);
    }
}
