<?php

namespace App\Http\Controllers\Admin;

use App\Application\UseCases\Admin\Category\CreateCategory\CreateCategoryUseCase;
use App\Application\UseCases\Admin\Category\UpdateCategory\UpdateCategoryUseCase;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Admin\Category\FromRequestToCreateInput as CreateCategoryMapper;
use App\Http\Mappers\Admin\Category\FromRequestToUpdateInput as UpdateCategoryMapper;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    // TODO: добавить Swagger
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

    // TODO: добавить Swagger
    public function update(
        int                   $categoryId,
        UpdateCategoryRequest $request,
        UpdateCategoryUseCase $useCase,
        UpdateCategoryMapper  $mapper,
    )
    {
        try {
            if ($output = $useCase->execute($mapper->map($categoryId, $request))) {
                return $this->getResponse(true, __('The category has been successfully updated'),
                    ['id' => $output->id]
                );
            }

            return $this->getResponse(false, __('Category not found'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }
}
