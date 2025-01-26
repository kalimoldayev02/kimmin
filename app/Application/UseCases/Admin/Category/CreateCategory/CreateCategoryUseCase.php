<?php

namespace App\Application\UseCases\Admin\Category\CreateCategory;

use App\Repositories\Category\CategoryRepository;
use Illuminate\Support\Str;

class CreateCategoryUseCase
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    public function execute(CreateCategoryInput $input): CreateCategoryOutput
    {
        $name = [
            'ru' => $input->nameRu,
            'kk' => $input->nameKk,
            'en' => $input->nameEn,
        ];

        $category = $this->categoryRepository->create([
            'name' => $name,
            'slug' => Str::slug($input->nameRu),
            'file_ids' => $input->fileIds,
        ]);

        return new CreateCategoryOutput($category->id);
    }
}