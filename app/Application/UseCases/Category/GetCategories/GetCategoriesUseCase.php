<?php

namespace App\Application\UseCases\Category\GetCategories;

use App\Services\Category\CategoryService;
use App\Application\UseCases\Category\DTO\GetCategoryOutput;

class GetCategoriesUseCase
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    /**
     * @return GetCategoryOutput[]
     */
    public function execute(GetCategoriesInput $input): array
    {
        $result = [];

        foreach ($this->categoryService->getCategories($input->page, $input->limit) as $category) {
            $result[] = new GetCategoryOutput(
                $category->id,
                $category->slug,
                $category->getTranslation('name', 'ru'),
                $category->getTranslation('name', 'kk'),
                $category->getTranslation('name', 'en'),
            );
        }

        return $result;
    }
}
