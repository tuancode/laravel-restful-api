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
     * Retrieves the collection of User resources
     *
     * @OA\Get(
     *     path="/api/v1/users",
     *     tags={"User"},
     *     security={
     *         {"passport": {}},
     *     },
     *     description="Retrieves the collection of User resources",
     *     operationId="findUsers",
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
     * Create a newly created user in application.
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
     * Display the specified resource.
     *
     * @param  User  $user
     * @return User
     */
    public function show(User $user): User
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User        $user
     *
     * @return User
     */
    public function update(UserRequest $request, User $user): User
    {
        $input = $request->all();

        $user->setName($input['name']);
        $user->setEmail($input['email']);
        $user->setPassword($input['password']);
        $user->save();

        return $user;
    }

    /**
     * Remove the User resource.
     *
     * @OA\Delete(
     *     path="/api/v1/users/{id}",
     *     tags={"User"},
     *     summary="Remove the User resource.",
     *     description="This can only be done by the logged in user.",
     *     operationId="deleteUser",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The user id needs to be deleted",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Successful delete User resource"),
     *     @OA\Response(response=404, description="User not found")
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
