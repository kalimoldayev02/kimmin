<?php

namespace App\Http\Controllers\Admin;

use App\Application\UseCases\Admin\Category\CreateCategory\CreateCategoryUseCase;
use App\Application\UseCases\Admin\Category\GetCategory\GetCategoryUseCase;
use App\Application\UseCases\Admin\Category\GetCategories\GetCategoriesUseCase;
use App\Application\UseCases\Admin\Category\UpdateCategory\UpdateCategoryUseCase;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Admin\Category\FromRequestToCreateInput as CreateCategoryInputMapper;
use App\Http\Mappers\Admin\Category\FromOutputToCreateCategoryResponse as CreateCategoryResponseMapper;
use App\Http\Mappers\Admin\Category\FromOutputToUpdateCategoryResponse as UpdateCategoryResponseMapper;
use App\Http\Mappers\Admin\Category\FromRequestToGetCategoryInput as GetCategoryInputMapper;
use App\Http\Mappers\Admin\Category\FromRequestToUpdateInput as UpdateCategoryInputMapper;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    // TODO: добавить Swagger
    public function createCategory(
        CreateCategoryRequest        $request,
        CreateCategoryUseCase        $useCase,
        CreateCategoryInputMapper    $inputMapper,
        CreateCategoryResponseMapper $outputMapper,
    ): JsonResponse
    {
        try {
            $output = $useCase->execute($inputMapper->map($request));

            return $this->getResponse(true, __('The category has been successfully created'),
                $outputMapper->map($output)
            );
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }

    // TODO: добавить Swagger
    public function updateCategory(
        int                          $categoryId,
        UpdateCategoryRequest        $request,
        UpdateCategoryUseCase        $useCase,
        UpdateCategoryInputMapper    $inputMapper,
        UpdateCategoryResponseMapper $outputMapper,
    )
    {
        try {
            if ($output = $useCase->execute($inputMapper->map($categoryId, $request))) {
                return $this->getResponse(true, __('The category has been successfully updated'),
                    $outputMapper->map($output)
                );
            }

            return $this->getResponse(false, __('Category not found'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }

    // TODO: добавить Swagger
    public function getCategory(
        int                    $categoryId,
        GetCategoryUseCase     $useCase,
        GetCategoryInputMapper $inputMapper,
    )
    {
        try {
            if ($output = $useCase->execute($inputMapper->map($categoryId))) {
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
                        'id'      => $output->id,
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

    // TODO: добавить Swagger
    public function getCategories(
        GetCategoriesUseCase $useCase
    )
    {
        try {
            if ($outputs = $useCase->execute()) {
                $categories = [];
                foreach ($outputs as $output) {
                    $files = [];
                    foreach ($output->files as $file) {
                        $files[] = [
                            'id'   => $file->id,
                            'sort' => $file->sort,
                            'name' => $file->name,
                            'path' => $file->path,
                        ];
                    }

                    $categories[] = [
                        'id'      => $output->id,
                        'name_ru' => $output->nameRu,
                        'name_kk' => $output->nameKk,
                        'name_en' => $output->nameEn,
                        'slug'    => $output->slug,
                        'files'   => $files,
                    ];
                }

                return $this->getResponse(true, '', $categories);
            }

            return $this->getResponse(false, __('Category not found'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }
}
