<?php

namespace App\Http\Controllers\Api;

use OpenApi\Attributes as OA;
use App\Http\Controllers\Controller;

#[OA\Info(version: "1.0.0", title: "KIMMIN API Documentation")]
#[OA\PathItem(path:"/api")]
abstract class BaseController extends Controller
{

}
