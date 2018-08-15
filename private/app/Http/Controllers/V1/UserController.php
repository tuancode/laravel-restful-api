<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\IndexRequest;
use App\Http\Requests\User\PopulateRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    /**
     * Retrieves the collection of User resources.
     *
     * @OA\Get(
     *     path="/users",
     *     tags={"User"},
     *     description="This can only be done by the logged in user.",
     *     operationId="indexUsers",
     *     security={
     *         {"passport": {}},
     *     },
     *     @OA\Parameter(name="sort", in="query", description="Use commas for multiple, minus (-) for descending order", @OA\Schema(type="string")),
     *     @OA\Parameter(name="page[number]", in="query", description="Current page number", @OA\Schema(type="string")),
     *     @OA\Parameter(name="page[size]", in="query", description="Limit item per page", @OA\Schema(type="string")),
     *     @OA\Parameter(name="filter[name]", in="query", description="Filter by name", @OA\Schema(type="string")),
     *     @OA\Parameter(name="filter[email]", in="query", description="Filter by email", @OA\Schema(type="string")),
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
     * @param IndexRequest $request
     * @param User         $user
     *
     * @return UserCollection
     */
    public function index(IndexRequest $request, User $user): UserCollection
    {
        $sort = $request->query->get('sort');
        $page = $request->query->get('page', []);
        $filter = $request->query->get('filter', []);

        return new UserCollection($user->search($sort, $page, $filter));
    }

    /**
     * Creates a User resource.
     *
     * @OA\Post(
     *     path="/users",
     *     tags={"User"},
     *     description="This can only be done by the logged in user.",
     *     operationId="storeUser",
     *     security={
     *         {"passport": {}},
     *     },
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
     *     @OA\Response(response=422, description="Invalid input")
     * )
     *
     * @param PopulateRequest $request
     *
     * @return UserResource
     */
    public function store(PopulateRequest $request): UserResource
    {
        return new UserResource(User::create($request->all()));
    }

    /**
     * Retrieves a User resource.
     *
     * @OA\Get(
     *     path="/users/{id}",
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
     * @param  string  $id
     *
     * @return UserResource
     */
    public function show(string $id): UserResource
    {
        return new UserResource(User::findOrFail(explode(',', $id)));
    }

    /**
     * Replaces the User resource.
     *
     * @OA\Put(
     *     path="/users/{id}",
     *     tags={"User"},
     *     description="This can only be done by the logged in user.",
     *     operationId="updateUser",
     *     security={
     *         {"passport": {}},
     *     },
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
     * @param PopulateRequest $request
     * @param User            $user
     *
     * @return UserResource
     */
    public function update(PopulateRequest $request, User $user): UserResource
    {
        $input = $request->all();

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = $input['password'];
        $user->save();

        return new UserResource($user);
    }

    /**
     * Removes the User resource.
     *
     * @OA\Delete(
     *     path="/users/{id}",
     *     tags={"User"},
     *     summary="Removes the User resource.",
     *     description="This can only be done by the logged in user.",
     *     operationId="destroyUser",
     *     security={
     *         {"passport": {}},
     *     },
     *     @OA\Parameter(name="id", in="path", description="UUID", required=true, @OA\Schema(type="string")),
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
