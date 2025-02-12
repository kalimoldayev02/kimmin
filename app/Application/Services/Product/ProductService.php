<?php

namespace App\Application\Services\Product;

use App\Models\Product;
use App\Helpers\PaginationHelper;
use App\Repositories\Product\ProductRepository;
use App\Application\Exceptions\Product\DuplicateSlugException;

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository,
    )
    {
    }

    public function createProduct(array $data): void
    {
        $this->checkProductOnDuplicateSlug($data['slug']);

        $this->productRepository->createProduct($data);
    }

    public function updateProduct(array $data): void
    {
        $this->checkProductOnDuplicateSlugWithoutId($data['id'], $data['slug']);

        $this->productRepository->updateProduct($data);
    }

    public function getProductFileIds(int $productId): array
    {
        return $this->productRepository->getProductFileIds($productId);
    }

    public function getProductById(int $productId): ?Product
    {
        return $this->productRepository->getProductById($productId);
    }

    public function checkProductOnDuplicateSlug(string $slug): void
    {
        if ($this->productRepository->getProductBySlug($slug)) {
            throw new DuplicateSlugException($slug);
        }
    }

    public function checkProductOnDuplicateSlugWithoutId(int $id, string $slug): void
    {
        if ($this->productRepository->getProductBySlugWithoutId($id, $slug)) {
            throw new DuplicateSlugException($slug);
        }
    }

    public function getPaginatedProducts(int $page, int $limit, array $relations = []): array
    {
        $paginator = $this->productRepository->getPaginatedProducts(
            select: ['id', 'slug', 'name'],
            relations: $relations,
            orders: ['id' => 'desc'],
            page: $page,
            pageLimit: $limit,
        );

        return PaginationHelper::prepare($page, $limit, $paginator->total(), $paginator->items());
    }

    public function deleteProduct(int $productId): void
    {
        $this->productRepository->deleteProduct($productId);
    }

    public function getProductBySlug(string $slug, array $relations = []): ?Product
    {
        return $this->productRepository->getProductBySlug($slug, $relations);
    }
}