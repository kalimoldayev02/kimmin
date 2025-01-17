<?php

namespace App\Application\DTO;

class LoginInputDTO
{
    public function __construct(
        public string $email,
        public string $password,
    )
    {
    }
}