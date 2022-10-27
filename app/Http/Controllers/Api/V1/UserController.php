<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $this->authorize('viewAny', User::class);

        $userCollection = $this->userService->filter($request->query());

        return UserResource::collection($userCollection);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        return response('store');
    }

    /**
     * @throws AuthorizationException
     */
    public function show(User $user): UserResource
    {
        $this->authorize('view', $user);

        return new UserResource($user);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        return response('update');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        return response('destroy');
    }
}
