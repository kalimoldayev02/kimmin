<?php

namespace App\Http\Controllers\Admin;

use App\Application\UseCases\Admin\Category\CreateCategory\CreateCategoryUseCase;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Admin\Category\FromRequestToCreateInput as CreateCategoryMapper;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function create(
        CreateCategoryRequest $request,
        CreateCategoryUseCase $useCase,
        CreateCategoryMapper  $mapper,
    ): JsonResponse
    {
        try {
            $output = $useCase->execute($mapper->map($request));

            return $this->getResponse(true, __('The category has been successfully created'),
                ['id' => $output->id]
            );
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }
}
