<?php

namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository
{
    public function create(array $data): Product
    {
        $product = Product::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'],
        ]);

        $product->files()->attach($data['file_ids']);
        $product->categories()->attach($data['category_ids']);

        return $product;
    }
}
