<?php

namespace App\Application\UseCases\Category\UpdateCategory;

use App\Services\Category\CategoryService;

class UpdateCategoryUseCase
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function execute(UpdateCategoryInput $input): void
    {
        $this->categoryService->updateCategory([
            'id'       => $input->id,
            'slug'     => $input->slug,
            'name' => [
                'ru' => $input->nameRu,
                'kk' => $input->nameKk,
                'en' => $input->nameEn,
            ],
        ]);
    }
}