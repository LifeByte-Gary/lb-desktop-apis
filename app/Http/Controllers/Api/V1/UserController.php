<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $userCollection = $this->userService->filter($request->query());

        return UserResource::collection($userCollection);
    }

    public function store(StoreUserRequest $request)
    {
        return response('store');
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        return response('update');
    }

    public function destroy(User $user)
    {
        return response('destroy');
    }
}
