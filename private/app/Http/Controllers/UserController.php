<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

/**
 * UserController
 */
class UserController extends Controller
{
    /**
     * Retrieves the collection of User resources.
     *
     * @OA\Get(
     *     path="/v1/users",
     *     tags={"User"},
     *     security={
     *         {"passport": {}},
     *     },
     *     description="This can only be done by the logged in user.",
     *     operationId="indexUsers",
     *     @OA\Response(
     *         response=200,
     *         description="User collection response",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/User"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return User::all();
    }

    /**
     * Creates a User resource.
     *
     * @OA\Post(
     *     path="/v1/users",
     *     tags={"User"},
     *     security={
     *         {"passport": {}},
     *     },
     *     description="This can only be done by the logged in user.",
     *     operationId="storeUser",
     *     @OA\Response(
     *         response=201,
     *         description="User resource created",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=422, description="Invalid input"),
     *     @OA\RequestBody(
     *         description="Register a new User resource",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string", example="Name"),
     *                 @OA\Property(property="email", type="string", example="user@example.com"),
     *                 @OA\Property(property="password", type="string", example="my-password"),
     *             )
     *         )
     *     )
     * )
     *
     * @param UserRequest $request
     *
     * @return User
     */
    public function store(UserRequest $request): User
    {
        return User::create($request->all());
    }

    /**
     * Retrieves a User resource.
     *
     * @OA\Get(
     *     path="/v1/users/{id}",
     *     tags={"User"},
     *     security={
     *         {"passport": {}},
     *     },
     *     description="This can only be done by the logged in user.",
     *     operationId="showUser",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="UUID",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User resource response",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=404, description="Resource not found")
     * )
     *
     * @param  User  $user
     * @return User
     */
    public function show(User $user): User
    {
        return $user;
    }

    /**
     * Replaces the User resource.
     *
     * @OA\Put(
     *     path="/v1/users/{id}",
     *     tags={"User"},
     *     security={
     *         {"passport": {}},
     *     },
     *     description="This can only be done by the logged in user.",
     *     operationId="updateUser",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="UUID",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User resource created",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=422, description="Invalid input"),
     *     @OA\Response(response=404, description="Resource not found"),
     *     @OA\RequestBody(
     *         description="Register a new User resource",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string", example="Name"),
     *                 @OA\Property(property="email", type="string", example="user@example.com"),
     *                 @OA\Property(property="password", type="string", example="my-password"),
     *             )
     *         )
     *     )
     * )
     *
     * @param UserRequest $request
     * @param User        $user
     *
     * @return User
     */
    public function update(UserRequest $request, User $user): User
    {
        $input = $request->all();

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = $input['password'];
        $user->save();

        return $user;
    }

    /**
     * Removes the User resource.
     *
     * @OA\Delete(
     *     path="/v1/users/{id}",
     *     tags={"User"},
     *     security={
     *         {"passport": {}},
     *     },
     *     summary="Removes the User resource.",
     *     description="This can only be done by the logged in user.",
     *     operationId="destroyUser",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="UUID",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=204, description="Successful delete User resource"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=404, description="Resource not found")
     * )
     *
     * @param User $user
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
