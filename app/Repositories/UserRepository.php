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
//        dd($filter);
//        $query = User::query()
//            ->when($filter['name'], static function ($query, $name) {
//                $query->where('name', 'like', "%$name%");
//            });
//            ->when($filter['email'], static function ($query, $email) {
//                $query->where('email', 'like', "%$email%");
//            })
//            ->when($filter['department'], function ($query, $department) {
//                $query->where('department', $department);
//            })
//            ->when($filter['job_title'], function ($query, $jobTitle) {
//                $query->where('job_title', 'like', "%$jobTitle%");
//            })
//            ->when($filter['company'], function ($query, $company) {
//                $query->where('company', 'like', "%$company%");
//            })
//            ->when($filter['desk'], function ($query, $desk) {
//                $query->where('desk', 'like', "%$desk%");
//            })
//            ->when($filter['type'], function ($query, $type) {
//                $query->where('type', $type);
//            });
//            ->when($filter['state'], function ($query, $state) {
//                $query->where('state', $state);
//            })
//            ->when($filter['permission_level'], function ($query, $permissionLevel) {
//                $query->where('permission_level', $permissionLevel);
//            });

//        if (isset($filter['state'])) {
//            $query->where('state', $filter['state']);
//        }
//
//        if (isset($filter['permission_level'])) {
//            $query->where('permission_level', $filter['permission_level']);
//        }

//        return $filter['pagination'] ? $query->paginate() : $query->get();

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
