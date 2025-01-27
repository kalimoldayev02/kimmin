<?php

namespace App\Http\Controllers\Admin;

use App\Application\UseCases\Admin\Category\CreateCategory\CreateCategoryUseCase;
use App\Application\UseCases\Admin\Category\GetCategory\GetCategoryUseCase;
use App\Application\UseCases\Admin\Category\UpdateCategory\UpdateCategoryUseCase;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Admin\Category\FromRequestToCreateInput as CreateCategoryMapper;
use App\Http\Mappers\Admin\Category\FromRequestToGetCategoryInput as GetCategoryMapper;
use App\Http\Mappers\Admin\Category\FromRequestToUpdateInput as UpdateCategoryMapper;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    // TODO: добавить Swagger
    public function createCategory(
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
    public function updateCategory(
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

    // TODO: добавить Swagger
    public function getCategory(
        int                $categoryId,
        GetCategoryUseCase $useCase,
        GetCategoryMapper  $mapper,
    )
    {
        try {
            if ($output = $useCase->execute($mapper->map($categoryId))) {
                $files = [];
                foreach ($output->files as $file) {
                    $files[] = [
                        'id'   => $file->id,
                        'sort' => $file->sort,
                        'name' => $file->name,
                        'path' => $file->path,
                    ];
                }

                return $this->getResponse(true, '',
                    [
                        'id' => $output->id,
                        'name_ru' => $output->nameRu,
                        'name_kk' => $output->nameKk,
                        'name_en' => $output->nameEn,
                        'slug'    => $output->slug,
                        'files'   => $files,
                    ]
                );
            }

            return $this->getResponse(false, __('Category not found'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }
}
