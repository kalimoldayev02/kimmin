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
}