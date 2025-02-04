<?php

namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository
{
    public function __construct(private Product $productModel)
    {
    }

    public function create(array $data): void
    {
        $product = $this->productModel->create([
            'name'        => $data['name'],
            'slug'        => $data['slug'],
            'price'       => $data['price'],
            'description' => $data['description'],
        ]);

        $product->files()->attach($data['file_ids']);
    }

    public function update(array $data): void
    {
        $product = $this->productModel->find($data['id']);

        if (!$product) {
            return;
        }

        $product->update([
            'name'        => $data['name'],
            'slug'        => $data['slug'],
            'price'       => $data['price'],
            'description' => $data['description'],
        ]);

        $oldFileIds = $this->getProductFileIds($product->id);
        if ($fileDiffs = array_diff($oldFileIds, $data['file_ids'])) {
            $product->files()->detach($fileDiffs);
        }

        $product->files()->sync($data['file_ids']);
    }

    public function getProductById(int $id): ?Product
    {
        if ($product = Product::find($id)) {
            return $product;
        }

        return null;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return Product[]
     */
    public function getProducts(int $offset = 0, int $limit = 10): iterable
    {
        return Product::query()->offset($offset)->limit($limit)->get();
    }

    public function getProductFileIds(int $productId): array
    {
        $product = $this->productModel->find($productId);

        if (!$product) {
            return [];
        }

        return $product->files()->pluck('id')->toArray();
    }
}
