<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

#[OA\Info(version: "1.0.0", title: "KIMMIN API Documentation")]
#[OA\PathItem(path:"/")]
abstract class Controller
{
    /**
     * @param bool $status
     * @param string $message
     * @param array $data
     * @param array $errors
     * @return JsonResponse
     */
    protected function getResponse(bool $status = true, string $message = '', array $data = [], array $errors = []): JsonResponse
    {
        $responseData = ['success' => $status];

        if ($message) {
            $responseData['message'] = $message;
        }

        if ($data) {
            $responseData['data'] = $data;
        }

        if ($errors) {
            $responseData['data'] = $errors;
        }

        return response()->json($responseData, $this->getStatusCode($status));
    }

    /**
     * @param bool $status
     * @return int
     */
    private function getStatusCode(bool $status): int
    {
        if ($status) {
            return Response::HTTP_OK;
        }
        return Response::HTTP_BAD_REQUEST;
    }
}
