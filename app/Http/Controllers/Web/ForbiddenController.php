<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;

class ForbiddenController extends Controller
{
    public function forbidden()
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Forbidden'
        ]));
    }

}
