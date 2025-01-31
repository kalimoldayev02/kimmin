<?php

namespace App\Application\UseCases\Admin\Category\UpdateCategory;

use App\Events\File\FileDeleted;
use App\Models\Category;
use App\Models\File;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Support\Str;

class UpdateCategoryUseCase
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    public function execute(UpdateCategoryInput $input): ?UpdateCategoryOutput
    {
        if ($category = Category::find($input->categoryId)) {
            $name = [
                'ru' => $input->nameRu,
                'kk' => $input->nameKk,
                'en' => $input->nameEn,
            ];

            // TODO: перенести логику в Service
            $oldFileIds = $category->files()->pluck('id')->toArray();
            if ($fileDiffs = array_diff($oldFileIds, $input->fileIds)) {
                foreach ($fileDiffs as $fileId) {
                    if ($file = File::find($fileId)) {
                        // TODO: надо проверить есть ли связи у файла
                        event(new FileDeleted($file));
                    }
                }
            }

            $this->categoryRepository->update([
                'id'   => $input->categoryId,
                'name' => $name,
                'slug' => $input->slug ?? Str::slug($input->nameRu),
                'file_ids' => $input->fileIds,
            ]);

            return new UpdateCategoryOutput($category->id);
        }

        return null;
    }
}