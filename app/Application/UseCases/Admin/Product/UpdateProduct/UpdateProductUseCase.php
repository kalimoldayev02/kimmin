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

            // TODO: перенести логику в Service
            $oldFileIds = $product->files()->pluck('id')->toArray();
            if ($fileDiffs = array_diff($oldFileIds, $input->fileIds)) {
                foreach ($fileDiffs as $fileId) {
                    if ($file = File::find($fileId)) {
                        event(new FileDeleted($file));
                    }
                }
            }

            $this->productRepository->update([
                'id'       => $input->productId,
                'price'    => $input->price,
                'name'     => $name,
                'slug'     => $input->slug ?? Str::slug($input->nameRu),
                'file_ids' => $input->fileIds,
            ]);

            return new UpdateProductOutput($input->id);
        }

        return null;
    }
}