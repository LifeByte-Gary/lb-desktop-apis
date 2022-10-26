<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->permittedUser1 = User::factory()->create([
        'permission_level' => 1
    ]);

    $this->permittedUser2 = User::factory()->create([
        'permission_level' => 2
    ]);

    $this->nonPermittedUser = User::factory()->create([
        'permission_level' => 0
    ]);
});

it('only allows permitted users to get user collection', function () {
    // Test user with permission level 1 can get user collection.
    actingAs($this->permittedUser1);
    getJson("/api/v1/users")
        ->assertOk()
        ->assertJsonCount(3, 'data');

    // Test user with permission level 2 can get user collection.
    actingAs($this->permittedUser2);
    getJson("/api/v1/users")
        ->assertOk()
        ->assertJsonCount(3, 'data');

    // Test user with permission level 0 can not get user collection.
    actingAs($this->nonPermittedUser);
    getJson("/api/v1/users")
        ->assertNotFound();
});

it('can return user collection in the correct format', function () {
    actingAs($this->permittedUser1);

    getJson("/api/v1/users")
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
    actingAs($this->permittedUser1);

    // Test filter by name.
    getJson("/api/v1/users?name=$this->permittedUser1->name")
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['id' => $this->permittedUser1->id]);
});
