<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserInterface
{
    public function filter(array $filter): Collection|LengthAwarePaginator;

    public function findOneBy(string $attribute, $value): User;
}
