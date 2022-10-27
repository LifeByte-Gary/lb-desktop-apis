<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

uses(RefreshDatabase::class);

it('only returns user collection to admin users', function () {
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
        ->assertJson(function (AssertableJson $json) {
            $json
                ->hasAll(['meta', 'links'])
                ->has('data', 3, function (AssertableJson $json) {
                    $json
                        ->hasAll([
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
                        ])
                        ->missingAll(['password', 'remember_token']);
                });
        });
});

it('can return correct user collection filtered by name', function () {
    actingAs($this->adminManager);

    $fuzzyName = 'User';
    getJson(route('api.v1.users.index', ['name' => $fuzzyName]))
        ->assertOk()
        ->assertJsonCount(3, 'data')
        ->assertJsonFragment(['id' => $this->adminManager->id])
        ->assertJsonFragment(['id' => $this->admin->id])
        ->assertJsonFragment(['id' => $this->normalUser->id]);

    $fuzzyName = 'One';
    getJson(route('api.v1.users.index', ['name' => $fuzzyName]))
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['id' => $this->adminManager->id]);
});
