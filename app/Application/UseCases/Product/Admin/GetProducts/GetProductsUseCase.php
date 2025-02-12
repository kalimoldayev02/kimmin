<?php

namespace App\Application\UseCases\Product\Admin\GetProducts;

use App\Application\Services\Product\ProductService;
use App\Models\File;
use App\Models\Product;

class GetProductsUseCase
{
    public function __construct(private ProductService $productService)
    {
    }

    public function execute(GetProductsInput $input): array
    {
        $items = [];
        $data = $this->productService->getPaginatedProducts($input->page, $input->limit, ['files']);

        /**
         * @var Product $product
         */
        foreach ($data['items'] as $product) {
            $files = [];
            /**
             * @var File $file
             */
            foreach ($product->files as $file) {
                $files[] = [
                    'id'        => $file->id,
                    'name'      => $file->name,
                    'path'      => $file->path,
                    'mime_type' => $file->mime_type
                ];
            }

            $items[] = [
                'id'   => $product->id,
                'slug' => $product->slug,
                'name' => [
                    'ru' => $product->getTranslation('name', 'ru'),
                    'kk' => $product->getTranslation('name', 'kk'),
                    'en' => $product->getTranslation('name', 'en'),
                ],
                'description' => [
                    'ru' => $product->getTranslation('description', 'ru'),
                    'kk' => $product->getTranslation('description', 'kk'),
                    'en' => $product->getTranslation('description', 'en'),
                ],
                'files' => $files,
            ];
        }

        return [
            'page'             => $data['page'],
            'page_limit'       => $data['page_limit'],
            'page_items_count' => $data['page_items_count'],
            'all_items_count'  => $data['all_items_count'],
            'items'            => $items,
        ];
    }
}
