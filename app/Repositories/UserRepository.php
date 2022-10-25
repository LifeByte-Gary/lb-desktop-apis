<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserInterface
{
    /**
     * Get the collection of users by filter.
     *
     * @param array $filter
     * @return Collection
     */
    public function filter(array $filter): Collection
    {
        return User::all();
    }

    /**
     * Find the user by attribute.
     *
     * @param string $attribute
     * @param $value
     * @return User
     */
    public function findOneBy(string $attribute, $value): User
    {
        if ($attribute === 'id') {
            return User::findOrFail($value);
        }

        return User::where($attribute, $value)->firstOrFail();
    }
}
