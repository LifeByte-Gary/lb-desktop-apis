<?php

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertModelExists;

uses(RefreshDatabase::class, WithoutEvents::class);

beforeEach(function () {
    $this->userRepository = new UserRepository();
});

it('can create a new user', function () {
    $attributes = User::factory()->make()->getAttributes();

    $user = $this->userRepository->create($attributes);

    assertDatabaseCount('users', 1);
    assertModelExists($user);
});

it('can update user attributes massively', function () {
    $user = createUser([
        'name' => 'Old Name',
        'company' => 'Old Company',
    ]);
    $payload = [
        'name' => 'New Name',
        'company' => 'New Company',
    ];

    $this->userRepository->update($user, $payload);

    assertDatabaseCount('users', 1);
    assertDatabaseHas('users', $payload);
});
