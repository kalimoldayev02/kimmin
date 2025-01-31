<?php

namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository
{
    public function create(array $data): Product
    {
        $product = Product::create([
            'name'        => $data['name'],
            'slug'        => $data['slug'],
            'price'       => $data['price'],
            'description' => $data['description'],
        ]);

        $product->files()->attach($data['file_ids']);
        $product->categories()->attach($data['category_ids']);

        return $product;
    }

    public function update(array $data): ?Product
    {
        $product = Product::find($data['id']);

        if (!$product) {
            return null;
        }

        $product->update([
            'name'        => $data['name'],
            'slug'        => $data['slug'],
            'price'       => $data['price'],
            'description' => $data['description'],
        ]);

        $oldFileIds = $product->files()->pluck('id')->toArray();
        if ($fileDiffs = array_diff($oldFileIds, $data['file_ids'])) {
            $product->files()->detach($fileDiffs);
        }

        $product->files()->sync($data['file_ids']);
        $product->categories()->sync($data['category_ids']);

        return $product;
    }

    public function getProductById(int $id): ?Product
    {
        if ($product = Product::find($id)) {
            return $product;
        }

        return null;
    }
}
