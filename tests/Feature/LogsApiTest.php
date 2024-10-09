<?php


use Tests\ApiTestCase;

class LogsApiTest extends ApiTestCase
{
    public const string RESOURCE_URI = '/api/logs';

    /**
     * Test reading a listing of the resource.
     */
    public function test_read_resource_list(): void
    {
        foreach (self::USER_EMAILS as $userName => $userEmail) {
            $actingAsUser = $this->getTestUserByEmail($userEmail);

            $response = $this->actingAs($actingAsUser)
                ->get(self::RESOURCE_URI);

            if ($userName == "user" || $userName == "usersAdmin" || $userName == "viewOnly") {
                $response->assertForbidden();
            } else {
                $response
                    ->assertOk()
                    ->assertJsonStructure([
                        'data' => [
                            [
                                'id',
                                'user_id',
                                'event',
                                'model',
                                'other_data',
                                'user',
                                'created_at',
                                'updated_at'
                            ]
                        ],
                        'links' => [
                            'first',
                            'last',
                            'prev',
                            'next'
                        ],
                        'meta' => [
                            'current_page',
                            'from',
                            'last_page',
                            'links',
                            'path',
                            'per_page',
                            'to',
                            'total'
                        ]
                    ]);
            }
        }
    }
}
