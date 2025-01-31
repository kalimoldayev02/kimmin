<?php

namespace App\Application\UseCases\Admin\Category\GetCategories;

use App\Application\UseCases\Admin\Category\DTO\GetCategoryOutput;
use App\Application\UseCases\Admin\File\DTO\FileOutput;
use App\Models\File;
use App\Repositories\Category\CategoryRepository;

class GetCategoriesUseCase
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    /**
     * @return GetCategoryOutput[]
     */
    public function execute(): array
    {
        $result = [];
        foreach ($this->categoryRepository->getCategories() as $category) {
            $files = [];
            /**
             * @var File $file
             */
            foreach ($category->files as $file) {
                $files[] = new FileOutput(
                    $file->id,
                    $file->name,
                    $file->path,
                    $file->sort
                );
            }

            $result[] = new GetCategoryOutput(
                $category->id,
                $category->getTranslation('name', 'ru'),
                $category->getTranslation('name', 'kk'),
                $category->getTranslation('name', 'en'),
                $category->slug,
                $files,
            );
        }

        return $result;
    }
}