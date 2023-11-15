<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

/**
 * Conatain some utility function to handel the response for api
 * @author Alimul-Mahfuz <alimulmahfuztushar@gamil.com>
 * @method mixed success() Handle success response
 * @method mixed error() Handle error response
 * @copyright 2023 MIS PRAN-RFL Group
 */
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
                'data' => $data,
                'message' => $message,
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
            'data' => $data,
            'message' => $message,
        ], $code);
    }
}
