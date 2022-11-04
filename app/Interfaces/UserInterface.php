<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserInterface
{
    public function filter(array $filter): Collection|LengthAwarePaginator;

    public function create(array $attributes): User;

    public function update(User $user, array $attributes);
}
