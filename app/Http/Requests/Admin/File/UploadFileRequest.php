<?php

namespace App\Http\Requests\Admin\File;

use App\Http\Requests\BaseRequest;

class UploadFileRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'directory'    => ['required', 'string'],
            'files'        => ['required', 'array'],
            'files.*.sort' => ['required', 'integer'],
            'files.*.file' => ['required', 'file', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }
}
