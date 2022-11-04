<?php

namespace App\Services;

use App\Events\UserCreated;
use App\Events\UserUpdated;
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
        $filter['paginate'] = !(isset($filter['paginate']) && ($filter['paginate'] === 'false' || (bool)$filter['paginate'] === false));

        return $this->userRepository->filter($filter);
    }

    /**
     * Create a user and store it into the database.
     *
     * @param $payload
     * @return User
     */
    public function create($payload): User
    {
        $passwordString = 'password';
        $payload['password'] = Hash::make($passwordString);

        $user = $this->userRepository->create($payload);

        UserCreated::dispatch($user, $passwordString);

        return $user;
    }

    /**
     * Update an existing user's attributes.
     *
     * @param User $user
     * @param array $payload
     * @return void
     */
    public function update(User $user, array $payload): void
    {
        $oldAttributes = $user->getAttributes();

        $this->userRepository->update($user, $payload);

        UserUpdated::dispatch($oldAttributes, $payload);
    }

    /**
     * Extract and parse user's attribute from a given array.
     *
     * @param array $payload
     * @return array
     */
    public function getAttributes(array $payload): array
    {
        $attributes = [];

        if (isset($payload['name'])) {
            $attributes['name'] = $payload['name'];
        }

        if (isset($payload['email'])) {
            $attributes['email'] = $payload['email'];
        }

        if (isset($payload['company'])) {
            $attributes['company'] = $payload['company'];
        }

        if (isset($payload['department'])) {
            $attributes['department'] = $payload['department'];
        }

        if (isset($payload['job_title'])) {
            $attributes['job_title'] = $payload['job_title'];
        }

        if (isset($payload['desk'])) {
            $attributes['desk'] = $payload['desk'];
        }

        if (isset($payload['state'])) {
            $attributes['state'] = (int)$payload['state'];
        }

        if (isset($payload['type'])) {
            $attributes['type'] = $payload['type'];
        }

        if (isset($payload['permission_level'])) {
            $attributes['permission_level'] = (int)$payload['permission_level'];
        }

        return $attributes;
    }
}
