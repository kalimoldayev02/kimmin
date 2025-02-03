<?php

namespace App\Application\UseCases\Category\GetCategory;

use App\Application\UseCases\Category\DTO\GetCategoryOutput;
use App\Services\Category\CategoryService;

class GetCategoryUseCase
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function execute(GetCategoryInput $input): ?GetCategoryOutput
    {
        $category = $this->categoryService->getCategoryById($input->id);

        if (!$category) {
            return null;
        }

        return new GetCategoryOutput(
            $category->id,
            $category->slug,
            $category->getTranslation('name', 'ru'),
            $category->getTranslation('name', 'kk'),
            $category->getTranslation('name', 'en'),
        );
    }
}
