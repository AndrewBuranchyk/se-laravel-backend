<?php


use Tests\TestCase;
use App\Observers\CardObserver;
use App\Models\{Log, Card};

class CardObserverTest extends TestCase
{
    public function test_created(): void
    {
        $card = Card::inRandomOrder()->first();
        (new CardObserver())->created($card);
        $log = Log::latest()->first();
        $this->assertEquals('Card', $log->model);
        $this->assertEquals('created', $log->event);
    }

    public function test_updated(): void
    {
        $card = Card::inRandomOrder()->first();
        (new CardObserver())->updated($card);
        $log = Log::latest()->first();
        $this->assertEquals('Card', $log->model);
        $this->assertEquals('updated', $log->event);
    }

    public function test_deleted(): void
    {
        $card = Card::inRandomOrder()->first();
        (new CardObserver())->deleted($card);
        $log = Log::latest()->first();
        $this->assertEquals('Card', $log->resource);
        $this->assertEquals('deleted', $log->event);
    }
}
