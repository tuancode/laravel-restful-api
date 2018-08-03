<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\User;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * AuthController
 */
class AuthController extends Controller
{
    /**
     * Register a new User resource.
     *
     * @OA\Post(
     *     path="/api/v1/register",
     *     tags={"Auth"},
     *     description="Register a new User resource",
     *     operationId="register",
     *     @OA\Response(
     *         response=200,
     *         description="User collection response",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\RequestBody(
     *         description="Register a new User resource",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     )
     * )
     *
     * @param AuthRequest $request
     *
     * @return JsonResponse
     */
    public function register(AuthRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->getName();

        return response()->json($success);
    }
}