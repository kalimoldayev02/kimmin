<?php

namespace App\Http\Requests\Admin\Product;

use App\Http\Requests\BaseRequest;

class UpdateProductRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id'      => ['required', 'array'],
            'price'           => ['required', 'int'],
            'name'            => ['required', 'array'],
            'name.ru'         => ['required', 'string', 'max:255'],
            'name.kk'         => ['required', 'string', 'max:255'],
            'name.en'         => ['required', 'string', 'max:255'],
            'category_ids'    => ['required', 'array'],
            'category_ids.*'  => ['required', 'int', 'exists:categories,id'],
            'description'     => ['required', 'array'],
            'description.ru'  => ['required', 'string'],
            'description.kk'  => ['required', 'string'],
            'description.en'  => ['required', 'string'],
            'file_ids'        => ['required', 'array'],
            'file_ids.*'      => ['required', 'int', 'min:0', 'exists:files,id'],
        ];
    }
}
