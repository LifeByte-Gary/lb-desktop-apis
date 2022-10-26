<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

uses(RefreshDatabase::class);

it('only allows permitted users to get user information', function () {
    $permittedUser1 = User::factory()->create([
        'permission_level' => 1
    ]);
    $permittedUser2 = User::factory()->create([
        'permission_level' => 2
    ]);
    $nonPermittedUser = User::factory()->create([
        'permission_level' => 0
    ]);

    // Test user with permission level 1 can get user information.
    actingAs($permittedUser1);
    $response = getJson("/api/v1/users/$permittedUser1->id");

    $response->assertOk()
        ->assertJsonFragment(['id' => $permittedUser1->id]);

    // Test user with permission level 2 can get user information.
    actingAs($permittedUser2);
    $response = getJson("/api/v1/users/$permittedUser1->id");

    $response->assertOk()
        ->assertJsonFragment(['id' => $permittedUser1->id]);

    // Test user with no permission can not get user information.
    actingAs($nonPermittedUser);
    $response = getJson("/api/v1/users/$permittedUser1->id");

    $response->assertNotFound();
});

it('returns user information in the correct format', function () {
    $permittedUser = User::factory()->create([
        'permission_level' => 2
    ]);
    actingAs($permittedUser);
    $response = getJson("/api/v1/users/$permittedUser->id");

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
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
        ])
        ->assertJsonMissingExact(['password' => $permittedUser->password]);
});
