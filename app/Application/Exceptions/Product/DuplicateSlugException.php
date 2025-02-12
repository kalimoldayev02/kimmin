<?php

namespace App\Application\Exceptions\Product;

use Exception;

class DuplicateSlugException extends Exception
{
    public function __construct(string $slug)
    {
        $message = __('The slug already exists in the database');
        parent::__construct(sprintf('%s: %s', $message, $slug));
    }
}