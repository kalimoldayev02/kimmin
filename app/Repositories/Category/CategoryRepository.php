<?php

namespace App\Repositories\Category;

use App\Models\Category;

class CategoryRepository
{
    public function __construct(private Category $categoryModel)
    {
    }

    public function createCategory(array $categoryData): void
    {
        $this->categoryModel->create([
            'name' => $categoryData['name'],
            'slug' => $categoryData['slug'],
        ]);
    }

    public function updateCategory(array $categoryData): void
    {
        $category = $this->categoryModel->find($categoryData['id']);

        if (!$category) {
            return;
        }

        $category->update([
            'name' => $categoryData['name'],
            'slug' => $categoryData['slug'],
        ]);
    }

    public function getCategoryById(int $categoryId): ?Category
    {
        if ($category = $this->categoryModel->find($categoryId)) {
            return $category;
        }

        return null;
    }

    /**
     * @return Category[]
     */
    public function getCategories(int $offset = 0, int $limit = 10): iterable
    {
        return $this->categoryModel->offset($offset)->limit($limit)->get();
    }

    public function deleteCategory(int $categoryId): void
    {
        if ($category = $this->getCategoryById($categoryId)) {
            $category->delete();
        }
    }
}
