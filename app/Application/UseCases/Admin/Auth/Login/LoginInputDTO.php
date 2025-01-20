<?php

namespace App\Application\UseCases\Admin\Auth\Login;

class LoginInputDTO
{
    public function __construct(
        public string $email,
        public string $password,
    )
    {
    }
}