<?php


use Tests\TestCase;
use App\Observers\DepartmentObserver;
use App\Models\{Log, Department};

class DepartmentObserverTest extends TestCase
{
    public function test_created(): void
    {
        $department = Department::inRandomOrder()->first();
        (new DepartmentObserver())->created($department);
        $log = Log::latest()->first();
        $this->assertEquals('Department', $log->model);
        $this->assertEquals('created', $log->event);
    }

    public function test_updated(): void
    {
        $department = Department::inRandomOrder()->first();
        (new DepartmentObserver())->updated($department);
        $log = Log::latest()->first();
        $this->assertEquals('Department', $log->model);
        $this->assertEquals('updated', $log->event);
    }

    public function test_deleted(): void
    {
        $department = Department::inRandomOrder()->first();
        (new DepartmentObserver())->deleted($department);
        $log = Log::latest()->first();
        $this->assertEquals('Department', $log->model);
        $this->assertEquals('deleted', $log->event);
    }
}
