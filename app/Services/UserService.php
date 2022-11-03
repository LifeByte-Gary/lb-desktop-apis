<?php

namespace App\Services;

use App\Events\UserCreated;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * Get the collection of users by filter.
     *
     * @param array $filter
     * @return Collection|LengthAwarePaginator
     */
    public function filter(array $filter): Collection|LengthAwarePaginator
    {
        $purifiedFilter = [
            'name' => $filter['name'] ?? null,
            'email' => $filter['email'] ?? null,
            'company' => $filter['company'] ?? null,
            'department' => $filter['department'] ?? null,
            'job_title' => $filter['job_title'] ?? null,
            'desk' => $filter['desk'] ?? null,
            'state' => isset($filter['state']) ? (int)$filter['state'] : null,
            'type' => $filter['type'] ?? null,
            'permission_level' => isset($filter['permission_level']) ? (int)$filter['permission_level'] : null,
            'paginate' => !(isset($filter['paginate']) && ($filter['paginate'] === 'false' || (bool)$filter['paginate'] === false)),
        ];

        return $this->userRepository->filter($purifiedFilter);
    }

    public function create($payload): User
    {
        $passwordString = 'password';
        $payload['password'] = Hash::make($passwordString);

        $user = $this->userRepository->create($payload);

        UserCreated::dispatch($user, $passwordString);

        return $user;
    }
}
