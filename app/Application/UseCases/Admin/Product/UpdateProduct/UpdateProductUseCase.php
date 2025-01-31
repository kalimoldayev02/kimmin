<?php

namespace App\Application\UseCases\Admin\Product\UpdateProduct;

use App\Models\File;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Events\File\FileDeleted;
use App\Repositories\Product\ProductRepository;

class UpdateProductUseCase
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function execute(UpdateProductInput $input)
    {
        if ($product = Product::find($input->productId)) {
            $name = [
                'ru' => $input->nameRu,
                'kk' => $input->nameKk,
                'en' => $input->nameEn,
            ];
            $description = [
                'ru' => $input->descriptionRu,
                'kk' => $input->descriptionKk,
                'en' => $input->descriptionEn,
            ];

            // TODO: перенести логику в Service
            $oldFileIds = $product->files()->pluck('id')->toArray();
            if ($fileDiffs = array_diff($oldFileIds, $input->fileIds)) {
                foreach ($fileDiffs as $fileId) {
                    if ($file = File::find($fileId)) {
                        // TODO: надо проверить есть связи у файла
                        event(new FileDeleted($file));
                    }
                }
            }

            $product = $this->productRepository->update([
                'id'           => $input->productId,
                'price'        => $input->price,
                'name'         => $name,
                'description'  => $description,
                'slug'         => $input->slug ?? Str::slug($input->nameRu),
                'file_ids'     => $input->fileIds,
                'category_ids' => $input->categoryIds,
            ]);

            return new UpdateProductOutput($product->id);
        }

        return null;
    }
}