<?php

namespace App\Http\Mappers\Category;

use Illuminate\Http\Request;
use App\Application\UseCases\Category\GetCategories\GetCategoriesInput;

class FromRequestToGetCategoriesInput
{
    public function map(Request $request): GetCategoriesInput
    {
        $page = $request->query('page', 1);
        $limit = $request->query('limit', env('LIMIT_DEFAULT', 10));

        return new GetCategoriesInput(max($page, 1), $limit);
    }
}
