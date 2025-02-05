<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Repositories\Product\ProductRepository;

class ProductService
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function createProduct(array $data): void
    {
        $this->productRepository->create($data);
    }

    public function updateProduct(array $data): void
    {
        $this->productRepository->update($data);
    }

    public function getProductFileIds(int $productId): array
    {
        return $this->productRepository->getProductFileIds($productId);
    }

    public function getProductById(int $productId): ?Product
    {
        return $this->productRepository->getProductById($productId);
    }
}