<?php

namespace App\Application\DTO;

class RegistrationInputDTO
{
    public function __construct(
        public string $email,
        public string $password,
    )
    {
    }
}