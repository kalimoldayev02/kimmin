<?php

namespace App\Application\UseCases\Category\CreateCategory;

use App\Services\Category\CategoryService;

class CreateCategoryUseCase
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function execute(CreateCategoryInput $input): void
    {
        $this->categoryService->createCategory([
            'name' => [
                'ru' => $input->nameRu,
                'kk' => $input->nameKk,
                'en' => $input->nameEn,
            ],
            'slug' => $input->slug,
        ]);
    }
}