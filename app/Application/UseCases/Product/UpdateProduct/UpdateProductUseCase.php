<?php

namespace App\Application\UseCases\Product\UpdateProduct;

use App\Application\Services\File\FileService;
use App\Application\Services\Product\ProductService;

class UpdateProductUseCase
{
    public function __construct(
        private FileService    $fileService,
        private ProductService $productService,
    )
    {
    }

    public function execute(UpdateProductInput $input): void
    {
        $oldFileIds = $this->productService->getProductFileIds($input->productId);
        $diffFileIds = array_diff($oldFileIds, $input->fileIds);

        $this->productService->updateProduct([
            'id'       => $input->productId,
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

        if ($diffFileIds) {
            $this->fileService->deleteFiles($diffFileIds);
        }
    }
}