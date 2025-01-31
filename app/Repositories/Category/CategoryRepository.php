<?php

namespace App\Repositories\Category;

use App\Models\Category;

class CategoryRepository
{
    public function create(array $data): Category
    {
        $category = Category::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
        ]);
        $category->files()->sync($data['file_ids']);

        return $category;
    }

    public function update(array $data): ?Category
    {
        $category = Category::find($data['id']);

        if (!$category) {
            return null;
        }

        $category->update([
            'name' => $data['name'],
            'slug' => $data['slug'],
        ]);

        $oldFileIds = $category->files()->pluck('id')->toArray();
        if ($fileDiffs = array_diff($oldFileIds, $data['file_ids'])) {
            $category->files()->detach($fileDiffs);
        }

        $category->files()->sync($data['file_ids']);

        return $category;
    }

    public function getCategoryById(int $id): ?Category
    {
        if ($category = Category::find($id)) {
            return $category;
        }

        return null;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return Category[]
     */
    public function getCategories(int $offset = 0, int $limit = 10): iterable
    {
        return Category::skip($offset)->take($limit)->get();
    }
}
