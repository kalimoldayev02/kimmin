<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class BaseRequest extends FormRequest
{
    /**
     * @param Validator $validator
     * @return void
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException(
            $validator,
            response()->json(
                [
                    'status' => false,
                    'message' => 'The given data was invalid',
                    'errors' => $validator->errors(),
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            )
        );
    }
}
