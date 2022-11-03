<?php

use App\Models\User;
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

it('can return correct user collection filtered by fuzzy name', function () {
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

it('can return correct user collection filtered by fuzzy email', function () {
    actingAs($this->adminManager);

    $fuzzyEmail = '@test.com';
    getJson(route('api.v1.users.index', ['email' => $fuzzyEmail]))
        ->assertOk()
        ->assertJsonCount(3, 'data')
        ->assertJsonFragment(['id' => $this->adminManager->id])
        ->assertJsonFragment(['id' => $this->admin->id])
        ->assertJsonFragment(['id' => $this->normalUser->id]);

    $fuzzyEmail = 'user.one';
    getJson(route('api.v1.users.index', ['email' => $fuzzyEmail]))
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['id' => $this->adminManager->id]);
});

it('can return correct user collection filtered by company', function () {
    actingAs($this->adminManager);

    $company = 'LifeByte System (AU)';
    getJson(route('api.v1.users.index', ['company' => $company]))
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonFragment(['id' => $this->adminManager->id])
        ->assertJsonFragment(['id' => $this->admin->id]);
});

it('can return correct user collection filtered by department', function () {
    actingAs($this->adminManager);

    $department = 'Support';
    getJson(route('api.v1.users.index', ['department' => $department]))
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonFragment(['id' => $this->adminManager->id])
        ->assertJsonFragment(['id' => $this->admin->id]);
});

it('can return correct user collection filtered by fuzzy job title', function () {
    actingAs($this->adminManager);

    $jobTitle = 'IT Support';
    getJson(route('api.v1.users.index', ['job_title' => $jobTitle]))
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonFragment(['id' => $this->adminManager->id])
        ->assertJsonFragment(['id' => $this->admin->id]);
});

it('can return correct user collection filtered by fuzzy Desk', function () {
    actingAs($this->adminManager);

    $desk = 'Desk 1';
    getJson(route('api.v1.users.index', ['desk' => $desk]))
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonFragment(['id' => $this->adminManager->id])
        ->assertJsonFragment(['id' => $this->admin->id]);
});

it('can return correct user collection filtered by state', function () {
    actingAs($this->adminManager);

    $state = $this->adminManager->state;
    getJson(route('api.v1.users.index', ['state' => $state]))
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['id' => $this->adminManager->id]);
});

it('can return correct user collection filtered by type', function () {
    $nonEmployeeUser = createUser(['type' => 'Meeting Room']);

    actingAs($this->adminManager);

    $type = $nonEmployeeUser->type;
    getJson(route('api.v1.users.index', ['type' => $type]))
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['id' => $nonEmployeeUser->id]);
});

it('can return correct user collection filtered by permission level', function () {
    actingAs($this->adminManager);

    $permissionLevel = $this->admin->permission_level;
    getJson(route('api.v1.users.index', ['permission_level' => $permissionLevel]))
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['id' => $this->admin->id]);
});

it('can disable pagination', function () {
    actingAs($this->adminManager);

    User::factory()->count(20)->create();

    getJson(route('api.v1.users.index', ['paginate' => false]))
        ->assertOk()
        ->assertJsonCount(23, 'data')
        ->assertJsonMissingPath('links')
        ->assertJsonMissingPath('meta');
});
