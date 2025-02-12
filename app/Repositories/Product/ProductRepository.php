<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends BaseRepository
{
    public function __construct(protected Product $model)
    {
    }

    protected function getAll(array $select = ['*'], array $filters = [], array $orders = [], int $limit = 15): Collection
    {
        $this->applyFilters($this->model, $filters);
        $this->applyOrders($this->model, $orders);

        return $this->model->get($select);
    }

    protected function getAllPaginated(
        array $select = ['*'],
        array $relations = [],
        array $filters = [],
        array $orders = [],
        int   $page = 1,
        int   $pageLimit = 15,
    ): LengthAwarePaginator
    {
        $this->applyFilters($this->model, $filters);
        $this->applyOrders($this->model, $orders);
        $this->applyRelations($this->model, $relations);

        return $this->model->select($select)->paginate(perPage: $pageLimit, page: $page);
    }

    protected function applyFilters(Model $model, array $filters): void
    {
        if (isset($filters['id'])) {
            $model->where('id', '=', $filters['id']);
        }

        if (isset($filters['slug'])) {
            $model->where('slug', '=', $filters['slug']);
        }

        if (isset($filters['not_id'])) {
            $model->where('id', '=', $filters['not_id']);
        }
    }

    protected function applyRelations(Model $model, array $relations): void
    {
        if ($relations) {
            $model->with($relations);
        }
    }

    public function createProduct(array $data): void
    {
        $product = $this->model->create([
            'name'        => $data['name'],
            'slug'        => $data['slug'],
            'price'       => $data['price'],
            'description' => $data['description'],
        ]);

        $product->files()->attach($data['file_ids']);
    }

    public function updateProduct(array $data): void
    {
        $product = $this->model->find($data['id']);

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
        if ($product = $this->model->find($id)) {
            return $product;
        }

        return null;
    }

    public function getProductFileIds(int $productId): array
    {
        $product = $this->model->find($productId);

        if (!$product) {
            return [];
        }

        return $product->files()->pluck('id')->toArray();
    }

    public function getProductBySlug(string $slug): ?Product
    {
        return $this->model->where('slug', trim($slug))->first();
    }

    public function getProductBySlugWithoutId(int $id, string $slug): ?Product
    {
        return $this->model->where('slug', trim($slug))
            ->where('id', '!=', $id)
            ->first();
    }

    public function getPaginatedProducts(
        array $select = ['*'],
        array $relations = [],
        array $filters = [],
        array $orders = [],
        int   $page = 1,
        int   $pageLimit = 15,
    ): LengthAwarePaginator
    {
        return $this->getAllPaginated($select, $relations, $filters, $orders, $page, $pageLimit);
    }

    public function deleteProduct(int $productId): void
    {
        if ($product = $this->getProductById($productId)) {
            $fileIds = [];
            foreach ($product->files as $file) {
                $fileIds[] = $file->id;
            }

            if ($fileIds) {
                $product->files()->detach($fileIds);
            }

            $product->delete();
        }
    }
}
