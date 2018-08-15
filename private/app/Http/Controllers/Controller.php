<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Tribe API",
 *     version="1.0",
 *     description="The private api of Tribe system"
 * )
 *
 * @OA\Server(
 *     url="/v1",
 * )
 *
 * @OA\SecurityScheme(
 *     type="oauth2",
 *     securityScheme="passport"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Send error response
     *
     * @param mixed        $error
     * @param object|array $errorMessage
     * @param int          $code
     *
     * @return JsonResponse
     */
    public function sendError($error, $errorMessage = null, int $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error
        ];

        if (null !== $errorMessage) {
            $response['data'] = $errorMessage;
        }

        return response()->json($response, $code);
    }
}
