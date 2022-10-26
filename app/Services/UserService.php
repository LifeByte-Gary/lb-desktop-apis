<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
        // Purify filter: remove invalid filter attributes.
//        array_filter($filter, function ($key) {
//            $validAttributes = ['name', 'email', 'company', 'department', 'job_title', 'desk', 'state', 'type', 'permission_level', 'pagination'];
//            return in_array($key, $validAttributes);
//        }, ARRAY_FILTER_USE_KEY);
        $purifiedFilter = [
            'name' => $filter['name'] ?? null,
            'email' => $filter['email'] ?? null,
            'company' => $filter['company'] ?? null,
            'department' => $filter['department'] ?? null,
            'job_title' => $filter['job_title'] ?? null,
            'desk' => $filter['job_title'] ?? null,
            'state' => isset($filter['state']) ? (int)$filter['state'] : null,
            'type' => $filter['type'] ?? null,
            'permission_level' => isset($filter['permission_level']) ? (int)$filter['permission_level'] : null,
            'pagination' => !(isset($filter['paginate']) && $filter['paginate'] === 'false'),
        ];

        return $this->userRepository->filter($purifiedFilter);
    }
}
