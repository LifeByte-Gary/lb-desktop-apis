<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserInterface
{
    public function filter(array $filter): Collection;

    public function findOneBy(string $attribute, $value): User;
}
