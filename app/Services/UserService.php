<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;

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
     * @return Collection
     */
    public function filter(array $filter): Collection
    {
        return $this->userRepository->filter($filter);
    }


    /**
     * Find the user by ID.
     *
     * @param string $id
     * @return User
     */
    public function findById(string $id): User
    {
        return $this->userRepository->findOneBy('id', $id);
    }
}
