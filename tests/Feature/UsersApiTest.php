<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\ApiTestCase;
use App\Models\User;
use Tests\Datasets\UserDataProvider;

class UsersApiTest extends ApiTestCase
{
    public const string RESOURCE_URI = '/api/users';

    /**
     * Test reading a listing of the resource.
     */
    public function test_read_resource_list(): void
    {
        foreach (self::USER_EMAILS as $userName => $userEmail) {
            $actingAsUser = $this->getTestUserByEmail($userEmail);

            $response = $this->actingAs($actingAsUser)
                ->get(self::RESOURCE_URI);

            if ($userName == "user" || $userName == "viewOnly") {
                $response->assertForbidden();
            } else {
                $response
                    ->assertOk()
                    ->assertJsonStructure([
                        'data' => [
                            [
                                'id',
                                'department_id',
                                'name',
                                'email',
                                'role',
                                'department',
                                'created_at',
                                'updated_at'
                            ]
                        ]
                    ]);
            }
        }
    }

    /**
     * Test creating a new resource with right data
     *
     * @param  int  $department_id
     * @param  string  $name
     * @param  string  $password
     * @param  string  $role
     */
    #[DataProviderExternal(UserDataProvider::class, 'getRightUser')]
    public function test_create_resource_with_right_data(
        int $department_id = 0,
        string $name = '',
        string $password = '',
        string $role = '',
    ): void
    {
        foreach (self::USER_EMAILS as $userName => $userEmail) {
            $actingAsUser = $this->getTestUserByEmail($userEmail);

            do {
                $email = fake()->unique()->safeEmail();
            } while (User::where('email', $email)->first());

            $response = $this->actingAs($actingAsUser)
                ->postJson(self::RESOURCE_URI, compact(
                    'department_id', 'name', 'email', 'password', 'role')
                );

            if ($userName == "user" || $userName == "viewOnly") {
                $response->assertForbidden();
            } else {
                $response
                    ->assertValid()
                    ->assertCreated()
                    ->assertJsonStructure([
                        'data' => [
                            'id',
                            'department_id',
                            'name',
                            'email',
                            'role',
                            'department',
                            'created_at',
                            'updated_at'
                        ]
                    ]);
            }
        }
    }

    /**
     * Test creating a new resource with wrong data
     *
     * @param  int|string  $department_id
     * @param  int|string  $name
     * @param  string  $password
     * @param  string  $role
     */
    #[DataProviderExternal(UserDataProvider::class, 'getWrongUser')]
    public function test_create_resource_with_wrong_data(
        int|string $department_id = 0,
        int|string $name = '',
        string $password = '',
        string $role = '',
    ): void
    {
        foreach (self::USER_EMAILS as $userName => $userEmail) {
            $actingAsUser = $this->getTestUserByEmail($userEmail);

            do {
                $email = fake()->unique()->safeEmail();
            } while (User::where('email', $email)->first());

            $response = $this->actingAs($actingAsUser)
                ->postJson(self::RESOURCE_URI, compact(
                        'department_id', 'name', 'email', 'password', 'role')
                );

            if ($userName == "user" || $userName == "viewOnly") {
                $response->assertForbidden();
            } else {
                // $response->dump();
                $response->assertStatus(422);
            }

        }
    }

    /**
     * Test reading the specified resource with right id.
     */
    public function test_read_resource_with_right_id(): void
    {
        foreach (self::USER_EMAILS as $userName => $userEmail) {
            $actingAsUser = $this->getTestUserByEmail($userEmail);

            $user = User::inRandomOrder()->first();

            $response = $this->actingAs($actingAsUser)
                ->get(self::RESOURCE_URI . '/' . $user->id);

            if ($userName == "user" || $userName == "viewOnly") {
                $response->assertForbidden();
            } else {
                $response
                    ->assertOk()
                    ->assertJsonStructure([
                        'data' => [
                            'id',
                            'department_id',
                            'name',
                            'email',
                            'role',
                            'department',
                            'created_at',
                            'updated_at'
                        ]
                    ]);
            }
        }
    }

    /**
     * Test reading the specified resource with wrong id.
     */
    public function test_read_resource_with_wrong_id(): void
    {
        foreach (self::USER_EMAILS as $userName => $userEmail) {
            $actingAsUser = $this->getTestUserByEmail($userEmail);

            $user = User::orderBy('id', 'desc')->first();

            $response = $this->actingAs($actingAsUser)
                ->get(self::RESOURCE_URI . '/' . $user->id + 1);

            $response->assertNotFound();
        }
    }

    /**
     * Test updating the specified resource with right data
     *
     * @param  int  $department_id
     * @param  string  $name
     * @param  string  $password
     * @param  string  $role
     */
    #[DataProviderExternal(UserDataProvider::class, 'getRightUser')]
    public function test_update_resource_with_right_data(
        int $department_id = 0,
        string $name = '',
        string $password = '',
        string $role = '',
    ): void
    {
        foreach (self::USER_EMAILS as $userName => $userEmail) {
            $actingAsUser = $this->getTestUserByEmail($userEmail);

            $user = User::orderBy('id', 'desc')->first();

            do {
                $email = fake()->unique()->safeEmail();
            } while (User::where('email', $email)->first());

            $response = $this->actingAs($actingAsUser)
                ->putJson(self::RESOURCE_URI . '/' . $user->id, compact(
                        'department_id', 'name', 'email', 'password', 'role')
                );

            if ($userName == "user" || $userName == "viewOnly") {
                $response->assertForbidden();
            } else {
                $response
                    ->assertValid()
                    ->assertAccepted()
                    ->assertJsonStructure([
                        'data' => [
                            'id',
                            'department_id',
                            'name',
                            'email',
                            'role',
                            'department',
                            'created_at',
                            'updated_at'
                        ]
                    ]);
            }
        }
    }

    /**
     * Test updating the specified resource with wrong data
     *
     * @param  int|string  $department_id
     * @param  int|string  $name
     * @param  string  $password
     * @param  string  $role
     */
    #[DataProviderExternal(UserDataProvider::class, 'getWrongUser')]
    public function test_update_resource_with_wrong_data(
        int|string $department_id = 0,
        int|string $name = '',
        string $password = '',
        string $role = '',
    ): void
    {
        foreach (self::USER_EMAILS as $userName => $userEmail) {
            $actingAsUser = $this->getTestUserByEmail($userEmail);

            $user = User::orderBy('id', 'desc')->first();

            do {
                $email = fake()->unique()->safeEmail();
            } while (User::where('email', $email)->first());

            $response = $this->actingAs($actingAsUser)
                ->putJson(self::RESOURCE_URI . '/' . $user->id, compact(
                        'department_id', 'name', 'email', 'password', 'role')
                );

            if ($userName == "user" || $userName == "viewOnly") {
                $response->assertForbidden();
            } else {
                // $response->dump();
                $response->assertStatus(422);
            }

        }
    }

    /**
     * Test deleting the specified resource with right id.
     */
    public function test_delete_resource_with_right_id(): void
    {
        foreach (self::USER_EMAILS as $userName => $userEmail) {
            $actingAsUser = $this->getTestUserByEmail($userEmail);

            $user = User::orderBy('id', 'desc')->first();

            $response = $this->actingAs($actingAsUser)
                ->deleteJson(self::RESOURCE_URI . '/' . $user->id);

            if ($userName == "user" || $userName == "viewOnly") {
                $response->assertForbidden();
            } else {
                $response
                    ->assertOk();
            }
        }
    }

    /**
     * Test deleting the specified resource with wrong id.
     */
    public function test_delete_resource_with_wrong_id(): void
    {
        foreach (self::USER_EMAILS as $userName => $userEmail) {
            $actingAsUser = $this->getTestUserByEmail($userEmail);

            $user = User::orderBy('id', 'desc')->first();

            $response = $this->actingAs($actingAsUser)
                ->deleteJson(self::RESOURCE_URI . '/' . $user->id + 1);

            $response->assertNotFound();
        }
    }
}
