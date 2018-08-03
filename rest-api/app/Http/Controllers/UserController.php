<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::all();

        return response()->json($users);
    }

    /**
     * Create a newly created user in application.
     *
     * @param UserRequest $request
     *
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        $user = User::create($request->all());

        return response()->json($user, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User        $user
     *
     * @return JsonResponse
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        $input = $request->all();

        $user->setName($input['name']);
        $user->setEmail($input['email']);
        $user->setPassword($input['password']);
        $user->save();

        return response()->json($user);
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
     *         @OA\Schema(
     *             type="integer"
     *         )
     *   ),
     *     @OA\Response(response=404, description="User not found")
     * )
     *
     *
     * @param User $user
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json($user, Response::HTTP_NO_CONTENT);
    }
}
