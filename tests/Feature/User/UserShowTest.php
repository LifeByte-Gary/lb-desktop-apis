<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('only allows permitted users to get user information', function () {
    // Test user with permission level 2 can get user information.
    actingAs($this->adminManager)
        ->getJson("/api/v1/users/{$this->normalUser->id}")
        ->assertOk()
        ->assertJsonFragment(['id' => $this->normalUser->id]);

    // Test user with permission level 1 can get user information.
    actingAs($this->admin)
        ->getJson("/api/v1/users/{$this->normalUser->id}")
        ->assertOk()
        ->assertJsonFragment(['id' => $this->normalUser->id]);

    // Test user with permission level 0 can not get user information.
    actingAs($this->normalUser)
        ->getJson("/api/v1/users/{$this->normalUser->id}")
        ->assertNotFound();
});

it('returns user information in the correct format', function () {
    actingAs($this->admin)
        ->getJson("/api/v1/users/{$this->normalUser->id}")
        ->assertOk()
        ->assertJsonFragment([
            'id' => $this->normalUser->id,
            'name' => $this->normalUser->name,
            'email' => $this->normalUser->email,
            'company' => $this->normalUser->company,
            'department' => $this->normalUser->department,
            'job_title' => $this->normalUser->job_title,
            'desk' => $this->normalUser->desk,
            'state' => $this->normalUser->state,
            'type' => $this->normalUser->type,
            'permission_level' => $this->normalUser->permission_level,
            'created_at' => $this->normalUser->created_at,
            'updated_at' => $this->normalUser->updated_at,
        ])
        ->assertJsonMissingPath('data.password');
});
