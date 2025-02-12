<?php

namespace App\Application\UseCases\Product\DeleteProduct;

use App\Application\Services\File\FileService;
use App\Application\Services\Product\ProductService;

class DeleteProductUseCase
{
    public function __construct(
        private FileService    $fileService,
        private ProductService $productService,
    )
    {
    }

    public function execute(DeleteProductInput $input): void
    {
        $fileIds = $this->productService->getProductFileIds($input->productId);

        $this->productService->deleteProduct($input->productId);

        if ($fileIds) {
            $this->fileService->deleteFiles($fileIds);
        }
    }
}