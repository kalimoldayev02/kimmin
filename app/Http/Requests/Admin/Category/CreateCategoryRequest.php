<?php

namespace App\Http\Requests\Admin\Category;

use App\Http\Requests\BaseRequest;

class CreateCategoryRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name.ru'    => ['required', 'string', 'max:255'],
            'name.kk'    => ['required', 'string', 'max:255'],
            'name.en'    => ['required', 'string', 'max:255'],
            'file_ids'   => ['required', 'array'],
            'file_ids.*' => ['required', 'int', 'min:0'],
        ];
    }
}
