<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\{UserStoreRequest, UserUpdateRequest};

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return UserResource
     */
    public function store(UserStoreRequest $request): UserResource
    {
        $validatedFields = $request->validated();
        $user = User::create($validatedFields);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $validatedFields = $request->validated();
        $user->update($validatedFields);
        return (new UserResource($user))
            ->response()->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse | bool | null
     */
    public function destroy(User $user): JsonResponse | bool | null
    {
        if ($user->role == 'admin' && auth()->user()->role != 'admin') {
            return response()->json([
                'message' => "You don't have access to remove the admin user"
            ], Response::HTTP_FORBIDDEN);
        }

        return $user->delete();
    }
}
