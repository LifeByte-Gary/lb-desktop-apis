<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Set a user for the ease of testing.
        User::factory()->create([
            'name' => 'Gary Zhang',
            'email' => 'gary@lifebyte.io',
            'company' => 'LifeByte Systems (AU)',
            'department' => 'IT Support',
            'job_title' => 'IT',
            'desk' => '1',
            'state' => 1,
            'type' => 'Employee',
            'permission_level' => 2
        ]);

        User::factory()
            ->count(500)
            ->create();
    }
}
