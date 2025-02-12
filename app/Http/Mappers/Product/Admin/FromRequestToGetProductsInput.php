<?php

namespace App\Http\Mappers\Product\Admin;

use App\Application\UseCases\Product\Admin\GetProducts\GetProductsInput;
use Illuminate\Http\Request;
use function env;

class FromRequestToGetProductsInput
{
    public function map(Request $request): GetProductsInput
    {
        $page = $request->query('page', 1);
        $limit = $request->query('limit', env('LIMIT_DEFAULT', 10));

        return new GetProductsInput(max($page, 1), $limit);
    }
}
