<?php


use Tests\TestCase;
use App\Observers\UserObserver;
use App\Models\{Log, User};

class UserObserverTest extends TestCase
{
    public function test_created(): void
    {
        $user = User::inRandomOrder()->first();
        (new UserObserver())->created($user);
        $log = Log::latest()->first();
        $this->assertEquals('User', $log->model);
        $this->assertEquals('created', $log->event);
    }

    public function test_updated(): void
    {
        $user = User::inRandomOrder()->first();
        (new UserObserver())->updated($user);
        $log = Log::latest()->first();
        $this->assertEquals('User', $log->model);
        $this->assertEquals('updated', $log->event);
    }

    public function test_deleted(): void
    {
        $user = User::inRandomOrder()->first();
        (new UserObserver())->deleted($user);
        $log = Log::latest()->first();
        $this->assertEquals('User', $log->model);
        $this->assertEquals('deleted', $log->event);
    }
}
