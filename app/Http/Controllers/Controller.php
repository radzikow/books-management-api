<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param ResourceCollection|null $data
     *
     * @return JsonResponse
     */
    final public function responseSuccess($data = null): JsonResponse
    {
        $response = [
            'status' => 'success',
            'status_code' => Response::HTTP_OK,
            'data' => $data,
            'errors' => (new \stdClass()),
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param array $data
     *
     * @return JsonResponse
     */
    final public function responseUnprocessableEntityError(array $data = []): JsonResponse
    {
        return $this->errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $data);
    }

    /**
     * @param array $data
     *
     * @return JsonResponse
     */
    final public function responseUnauthorizedEntityError(array $data = []): JsonResponse
    {
        return $this->errorResponse(Response::HTTP_UNAUTHORIZED, $data);
    }

    /**
     * @param array $data
     *
     * @return JsonResponse
     */
    final public function responseNotFoundError(array $data = []): JsonResponse
    {
        return $this->errorResponse(Response::HTTP_NOT_FOUND, $data);
    }

    /**
     * @param array $data
     *
     * @return JsonResponse
     */
    final public function responseForbiddenError(array $data = []): JsonResponse
    {
        return $this->errorResponse(Response::HTTP_FORBIDDEN, $data);
    }

    /**
     * @param int $status
     * @param array $data
     *
     * @return JsonResponse
     */
    final private function errorResponse(int $status, array $data): JsonResponse
    {
        $response = [
            'status' => 'error',
            'status_code' => $status,
            'errors' => $data,
        ];

        return response()->json($response, $status);
    }
}
