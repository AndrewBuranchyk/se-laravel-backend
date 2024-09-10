<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\Datasets\UserDataProvider;

class UserDataProviderTest extends TestCase
{
    public function test_getRightUser(): void
    {
        $result = (new UserDataProvider())->getRightUser();
        $this->assertIsArray($result);
        $this->assertIsString($result['Right User']['name']);
        // print_r($result);
    }
}
