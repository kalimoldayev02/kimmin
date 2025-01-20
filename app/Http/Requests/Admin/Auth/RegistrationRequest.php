<?php

namespace App\Http\Requests\Admin\Auth;

use App\Http\Requests\BaseRequest;

class RegistrationRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email'    => ['required', 'email', 'unique:users'],
            'password' => ['required']
        ];
    }
}
