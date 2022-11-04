<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserInterface
{
    /**
     * Get the collection of users by filter.
     *
     * @param array $filter
     * @return Collection|LengthAwarePaginator
     */
    public function filter(array $filter): Collection|LengthAwarePaginator
    {
        $query = User::query();

        if (isset($filter['name'])) {
            $query->where('name', 'like', "%${filter['name']}%");
        }

        if (isset($filter['email'])) {
            $query->where('email', 'like', "%${filter['email']}%");
        }

        if (isset($filter['company'])) {
            $query->where('company', $filter['company']);
        }

        if (isset($filter['department'])) {
            $query->where('department', $filter['department']);
        }

        if (isset($filter['job_title'])) {
            $query->where('job_title', 'like', "%${filter['job_title']}%");
        }

        if (isset($filter['desk'])) {
            $query->where('desk', 'like', "%${filter['desk']}%");
        }

        if (isset($filter['type'])) {
            $query->where('type', $filter['type']);
        }

        if (isset($filter['state'])) {
            $query->where('state', $filter['state']);
        }

        if (isset($filter['permission_level'])) {
            $query->where('permission_level', $filter['permission_level']);
        }

        return $filter['paginate'] ? $query->paginate() : $query->get();
    }

    /**
     * Insert a new user with given attributes into the database.
     *
     * @param array $attributes
     * @return User
     */
    public function create(array $attributes): User
    {
        return User::create($attributes);
    }

    /**
     * Update a user with given attributes.
     *
     * @param User $user
     * @param array $attributes
     * @return void
     */
    public function update(User $user, array $attributes): void
    {
        if (count($attributes) === 0) {
            return;
        }

        foreach ($attributes as $key => $value) {
            $user[$key] = $value;
        }

        $user->save();
    }
}
