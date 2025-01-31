<?php

namespace App\Application\UseCases\Admin\Product\UpdateProduct;

class UpdateProductOutput
{
    public function __construct(
        public int $id
    )
    {
    }
}
