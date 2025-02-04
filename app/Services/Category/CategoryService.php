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
        $this->categoryRepository->createCategory($data);
    }

    public function updateCategory(array $data): void
    {
        $this->categoryRepository->updateCategory($data);
    }

    public function getCategoryById(int $categoryId): ?Category
    {
        return $this->categoryRepository->getCategoryById($categoryId);
    }

    public function getCategories(int $offset, int $limit): iterable
    {
        return $this->categoryRepository->getCategories($offset, $limit);
    }

    public function deleteCategory(int $categoryId): void
    {
        $this->categoryRepository->deleteCategory($categoryId);
    }
}