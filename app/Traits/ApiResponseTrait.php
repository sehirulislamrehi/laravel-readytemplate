<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{

    /**
     * To handel success response
     *
     * @param mixed $data
     * @param string $message
     * @param integer $code
     * @return JsonResponse
     */
    protected function success($data, ?string $message = null, $code = 200): JsonResponse
    {
        return response()->json(
            [
                'status' => 'success',
                'message' => $message,
                'data' => $data,
            ],
            $code
        );
    }

    /**
     * To handel warning response
     *
     * @param mixed $data
     * @param string $message
     * @param integer $code
     * @return JsonResponse
     */
    protected function warning($data, ?string $message = null, $code = 200): JsonResponse
    {
        return response()->json(
            [
                'status' => 'warning',
                'message' => $message,
                'data' => $data,
            ],
            $code
        );
    }

    /**
     * To handel error response
     *
     * @param mixed $data
     * @param string $message
     * @param integer $code
     * @return JsonResponse
     */
    protected function error($data=null, ?string $message = null, $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * To handel location reload response
     *
     * @param mixed $data
     * @param string $message
     * @param integer $code
     * @return JsonResponse
     */
    protected function location_reload($data=null, ?string $message = null, $location_reload = true, $url = null, $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'location_reload' => $location_reload,
            'url' => $url,
        ], $code);
    }
}

