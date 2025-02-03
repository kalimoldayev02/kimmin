<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Repositories\Category\CategoryRepository;

class CategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepository,
    )
    {
    }

    public function createCategory(array $data): void
    {
        $this->categoryRepository->create($data);
    }

    public function updateCategory(array $data): void
    {
        $this->categoryRepository->update($data);
    }

    public function getCategoryById(int $categoryId): ?Category
    {
        return $this->categoryRepository->getCategoryById($categoryId);
    }

    public function getCategories(int $offset = 0, int $limit = 10): iterable
    {
        return $this->categoryRepository->getCategories($offset, $limit);
    }
}