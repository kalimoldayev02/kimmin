<?php

namespace App\Helpers;

class PaginationHelper
{
    public static function prepare(int $page, int $pageLimit, int $allItemsCount, array $items): array
    {
        return [
            'page'             => $page,
            'page_limit'       => $pageLimit,
            'items'            => $items,
            'page_items_count' => count($items),
            'all_items_count'  => $allItemsCount,
        ];
    }
}