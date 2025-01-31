<?php

namespace App\Application\UseCases\Admin\Category\GetCategory;

use App\Application\UseCases\Admin\Category\DTO\FileOutput;
use App\Application\UseCases\Admin\Category\DTO\GetCategoryOutput;
use App\Models\File;
use App\Repositories\Category\CategoryRepository;

class GetCategoryUseCase
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    public function execute(GetCategoryInput $input): ?GetCategoryOutput
    {
        $category = $this->categoryRepository->getCategoryById($input->id);

        if (!$category) {
            return null;
        }

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

        return new GetCategoryOutput(
            $category->id,
            $category->getTranslation('name', 'ru'),
            $category->getTranslation('name', 'kk'),
            $category->getTranslation('name', 'en'),
            $category->slug,
            $files,
        );
    }
}
