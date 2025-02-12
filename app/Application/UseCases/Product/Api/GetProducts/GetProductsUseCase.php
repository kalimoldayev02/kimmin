<?php

namespace App\Application\UseCases\Product\Api\GetProducts;

use App\Models\File;
use App\Models\Product;
use App\Application\Services\Product\ProductService;

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
                $files[] = [$file->path];
            }

            $items[] = [
                'id'    => $product->id,
                'slug'  => $product->slug,
                'name'  => $product->name,
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