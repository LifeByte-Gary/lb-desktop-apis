<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

uses(RefreshDatabase::class);

it('only returns user collection to permitted users', function () {
    // Test user with permission level 2 can get user collection.
    actingAs($this->adminManager)
        ->getJson("/api/v1/users")
        ->assertOk()
        ->assertJsonCount(3, 'data');

    // Test user with permission level 1 can get user collection.
    actingAs($this->admin)
        ->getJson("/api/v1/users")
        ->assertOk()
        ->assertJsonCount(3, 'data');

    // Test user with permission level 0 can not get user collection.
    actingAs($this->normalUser)
        ->getJson("/api/v1/users")
        ->assertNotFound();
});

it('returns user collection in the correct format', function () {
    actingAs($this->adminManager)
        ->getJson("/api/v1/users")
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                "*" => [
                    'id',
                    'name',
                    'email',
                    'company',
                    'department',
                    'job_title',
                    'desk',
                    'state',
                    'type',
                    'permission_level',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
});

it('can return correct user collection after filtering by attributes', function () {
    actingAs($this->adminManager);

    // Test filter by name.
    $fuzzyName = substr($this->adminManager->name, 0, -1);
    getJson(route('api.v1.users.index', ['name' => $fuzzyName]))
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['id' => $this->adminManager->id]);
});
