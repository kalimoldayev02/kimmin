<?php

namespace App\Http\Requests\Admin\File;

use App\Http\Requests\BaseRequest;

class GetFilesPathRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file_ids'   => ['required', 'array'],
            'file_ids.*' => ['required', 'int', 'min:1'],
        ];
    }
}
