<?php

namespace Tests\Feature\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\patchJson;

it('only allows permitted user to update', function () {
    $payload = [
        'name' => 'New Name',
        'company' => 'New Company',
    ];

    // Test unauthenticated user cannot update user information.
    patchJson("/api/v1/users/{$this->normalUser->id}", $payload)
        ->assertUnauthorized();

    // Test user with permission level 2 can get user information.
    actingAs($this->adminManager);
    patchJson("/api/v1/users/{$this->normalUser->id}", $payload)
        ->assertNoContent();

    // Test user with permission level 1 can get user information.
    actingAs($this->admin);
    patchJson("/api/v1/users/{$this->normalUser->id}", $payload)
        ->assertNoContent();

    // Test user with permission level 2 can get user information.
    actingAs($this->normalUser);
    patchJson("/api/v1/users/{$this->normalUser->id}", $payload)
        ->assertForbidden();
});
