<?php

namespace App\Application\DTOs;

class RegistrationInputDTO
{
    public function __construct(
        public string $email,
        public string $password,
    )
    {
    }
}