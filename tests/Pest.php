<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use App\Models\User;

uses(Tests\TestCase::class)->in('Feature');
uses(Tests\TestCase::class)->in('Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Create a user.
 *
 * @param array $attributes
 * @return User
 */
function createUser(array $attributes): User
{
    return User::factory()->create($attributes);
}

/*
|--------------------------------------------------------------------------
| Reusable (Shared) Setup and Teardown
|--------------------------------------------------------------------------
|
| At some point, you may need (or want) to share some kind of test scenario setup or teardown
| procedure.
|
*/

uses()
    ->beforeEach(function () {
        $this->adminManager = createUser([
            'name' => 'User One',
            'email' => 'user.one@test.com',
            'company' => 'LifeByte System (AU)',
            'department' => 'Support',
            'job_title' => 'Senior IT Support',
            'desk' => 'Desk 1',
            'type' => 'Employee',
            'state' => 1,
            'permission_level' => 2,
        ]);
        $this->admin = createUser([
            'name' => 'User Two',
            'email' => 'user.two@test.com',
            'company' => 'LifeByte System (AU)',
            'department' => 'Support',
            'job_title' => 'Junior IT Support',
            'desk' => 'Desk 10',
            'type' => 'Employee',
            'state' => 2,
            'permission_level' => 1,
        ]);
        $this->normalUser = createUser([
            'name' => 'User Three',
            'email' => 'user.three@test.com',
            'company' => 'LifeByte System (CN)',
            'department' => 'Marketing',
            'job_title' => 'Junior Marketing Consultant',
            'desk' => 'Desk 25',
            'type' => 'Employee',
            'state' => 0,
            'permission_level' => 0,
        ]);
    })
    ->in('Feature/User');
