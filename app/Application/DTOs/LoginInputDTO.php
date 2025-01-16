<?php

namespace App\Application\DTOs;

class LoginInputDTO
{
    public function __construct(
        public string $email,
        public string $password,
    )
    {
    }
}