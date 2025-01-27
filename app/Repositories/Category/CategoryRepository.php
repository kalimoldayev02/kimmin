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
        $category->files()->attach($data['file_ids']);

        return $category;
    }

    public function update(array $data): ?Category
    {
        if ($category = Category::find($data['id'])) {
            $category->update([
                'name' => $data['name'],
                'slug' => $data['slug'],
            ]);

            $oldFileIds = $category->files()->pluck('id')->toArray();
            if ($fileDiffs = array_diff($oldFileIds, $data['file_ids'])) {
                $category->files()->detach($fileDiffs);
            }

            $category->files()->attach($data['file_ids']);

            return $category;
        }

        return null;
    }
}
