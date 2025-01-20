<?php

namespace App\Application\UseCases\Admin\Category\CreateCategory;

use GuzzleHttp\Promise\Create;

class CreateCategoryUseCase
{
    public function execute(CreateCategoryInput $createCategoryInput): CreateCategoryOutput
    {
        return new CreateCategoryOutput(
            1,
        );
    }
}