<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    /**
     * Register a new User resource.
     *
     * @OA\Post(
     *     path="/registers",
     *     tags={"Auth"},
     *     description="Register a new User resource",
     *     operationId="authRegister",
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
     *                 @OA\Property(property="name", type="string", example="Name"),
     *                 @OA\Property(property="email", type="string", example="user@example.com"),
     *                 @OA\Property(property="password", type="string", example="my-password"),
     *                 @OA\Property(property="c_password", type="string", example="my-password")
     *             )
     *         )
     *     )
     * )
     *
     * @param RegisterRequest $request
     *
     * @return array
     */
    public function register(RegisterRequest $request): array
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        return $success;
    }

    /**
     * Request an API Token resource.
     *
     * @OA\Post(
     *     @OA\Server(url="/oauth"),
     *     path="/token",
     *     tags={"Auth"},
     *     description="Request an API Token resource.",
     *     operationId="authLogin",
     *     @OA\Response(
     *         response=200,
     *         description="API Token resource",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="token_type", type="string", example="Bearer"),
     *                 @OA\Property(property="expires_in", type="integer", example=86399),
     *                 @OA\Property(property="access_token", type="string"),
     *                 @OA\Property(property="refresh_token", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\RequestBody(
     *         description="Request an API Token resource.",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="grant_type", type="string", example="password"),
     *                 @OA\Property(property="client_id", type="integer", example=1),
     *                 @OA\Property(property="client_secret", type="string"),
     *                 @OA\Property(property="username", type="string", example="email@sample.com"),
     *                 @OA\Property(property="password", type="string", example="my-password"),
     *                 @OA\Property(property="scope", type="string")
     *             )
     *         )
     *     )
     * )
     */
}