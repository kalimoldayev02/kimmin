<?php

namespace App\Http\Mappers\Product\Api;

use function env;
use Illuminate\Http\Request;
use App\Application\UseCases\Product\Api\GetProducts\GetProductsInput;

class FromRequestToGetProductsInput
{
    public function map(Request $request): GetProductsInput
    {
        $page = $request->query('page', 1);
        $limit = $request->query('limit', env('LIMIT_DEFAULT', 10));

        return new GetProductsInput(max($page, 1), $limit);
    }
}
