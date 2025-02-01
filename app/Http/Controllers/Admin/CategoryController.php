<?php

namespace App\Http\Controllers\Admin;

use App\Application\UseCases\Admin\Category\CreateCategory\CreateCategoryUseCase;
use App\Application\UseCases\Admin\Category\GetCategories\GetCategoriesUseCase;
use App\Application\UseCases\Admin\Category\GetCategory\GetCategoryUseCase;
use App\Application\UseCases\Admin\Category\UpdateCategory\UpdateCategoryUseCase;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Admin\Category\FromOutputToCreateCategoryResponse as CreateCategoryResponseMapper;
use App\Http\Mappers\Admin\Category\FromOutputToGetCategoryResponse as GetCategoryResponseMapper;
use App\Http\Mappers\Admin\Category\FromOutputToUpdateCategoryResponse as UpdateCategoryResponseMapper;
use App\Http\Mappers\Admin\Category\FromRequestToCreateInput as CreateCategoryInputMapper;
use App\Http\Mappers\Admin\Category\FromRequestToGetCategoryInput as GetCategoryInputMapper;
use App\Http\Mappers\Admin\Category\FromRequestToUpdateCategoryInput as UpdateCategoryInputMapper;
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
    ): JsonResponse
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
        int                       $categoryId,
        GetCategoryUseCase        $useCase,
        GetCategoryInputMapper    $inputMapper,
        GetCategoryResponseMapper $responseMapper,
    ): JsonResponse
    {
        try {
            if ($output = $useCase->execute($inputMapper->map($categoryId))) {
                return $this->getResponse(true, '',
                    $responseMapper->map($output)
                );
            }

            return $this->getResponse(false, __('Category not found'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }

    // TODO: добавить Swagger
    public function getCategories(
        GetCategoriesUseCase      $useCase,
        GetCategoryResponseMapper $responseMapper,
    ): JsonResponse
    {
        try {
            if ($outputs = $useCase->execute()) {
                $responseData = [];
                foreach ($outputs as $output) {
                    $responseData[] = $responseMapper->map($output);
                }

                return $this->getResponse(true, '', $responseData);
            }

            return $this->getResponse(false, __('Category not found'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }
}
