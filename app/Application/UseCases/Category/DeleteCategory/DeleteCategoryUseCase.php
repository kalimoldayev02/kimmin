<?php

namespace App\Application\UseCases\Category\DeleteCategory;

use App\Services\Category\CategoryService;

class DeleteCategoryUseCase
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function execute(DeleteCategoryInput $input): void
    {
        $this->categoryService->deleteCategory($input->categoryId);
    }
}