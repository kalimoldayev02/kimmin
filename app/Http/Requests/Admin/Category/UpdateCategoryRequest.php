<?php

namespace App\Http\Requests\Admin\Category;

use App\Http\Requests\BaseRequest;

class UpdateCategoryRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'array'],
            'slug'       => ['required', 'string', 'unique:categories'],
            'name.ru'    => ['required', 'string', 'max:255'],
            'name.kk'    => ['required', 'string', 'max:255'],
            'name.en'    => ['required', 'string', 'max:255'],
        ];
    }
}
