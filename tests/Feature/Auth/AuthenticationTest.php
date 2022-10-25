<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

test('users can authenticate using correct credentials', function () {
    $user = User::factory()->create();

    $response = postJson('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    assertAuthenticatedAs($user);
    $response->assertValid()
        ->assertNoContent();
});

test('users can not authenticate using incorrect credentials', function () {
    $user = User::factory()->create();

    $response = postJson('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    assertGuest();
    $response->assertStatus(422)
        ->assertInvalid(['email']);
});
