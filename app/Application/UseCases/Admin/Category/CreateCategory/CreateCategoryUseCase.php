<?php

namespace App\Application\UseCases\Admin\Category\CreateCategory;

use App\Repositories\Category\CategoryRepository;
use Illuminate\Support\Str;

class CreateCategoryUseCase
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    public function execute(CreateCategoryInput $createCategoryInput): CreateCategoryOutput
    {
        $name = [
            'ru' => $createCategoryInput->nameRu,
            'kk' => $createCategoryInput->nameKk,
            'en' => $createCategoryInput->nameEn,
        ];

        $category = $this->categoryRepository->create([
            'name' => $name,
            'slug' => Str::slug($createCategoryInput->nameRu),
            'file_ids' => $createCategoryInput->fileIds,
        ]);

        return new CreateCategoryOutput($category->id);
    }
}