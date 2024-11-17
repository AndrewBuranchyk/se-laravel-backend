<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Log, Card};

class CardObserver
{
    protected string $event;
    protected string $otherData;
    protected array $fields = ['id'];

    /**
     * Handle the Card "created" event.
     *
     * @param  Card  $card
     * @return void
     */
    public function created(Card $card): void
    {
        $this->event = "created";
        $this->setOtherDataField($card)
            ->logEventForResource($card);
    }

    /**
     * Handle the Card "updated" event.
     *
     * @param  Card  $card
     * @return void
     */
    public function updated(Card $card): void
    {
        $this->event = "updated";
        $this->setOtherDataField($card)
            ->logEventForResource($card);
    }

    /**
     * Handle the Card "deleted" event.
     *
     * @param  Card  $card
     * @return void
     */
    public function deleted(Card $card): void
    {
        $this->event = "deleted";
        $this->setOtherDataField($card)
            ->logEventForResource($card);
    }

    /**
     * Log event for the resource
     *
     * @param Model $resource
     * @return bool
     */
    public function logEventForResource(Model $resource): bool
    {
        if (empty($resource->id)){
            return false;
        }

        Log::create([
            'user_id' => auth()->user()->id ?? null,
            'event' => $this->event ?? "store",
            'model' => 'Card',
            'other_data' => $this->otherData ?? null,
        ]);

        return true;
    }

    /**
     * Set other data field for the resource
     *
     * @param Model $resource
     * @return self
     */
    public function setOtherDataField(Model $resource): self
    {
        $resourceData = [];
        foreach ($this->fields as $item) {
            $resourceData[$item] = $resource?->$item;
        }

        if (!empty($resourceData)) {
            $this->otherData = json_encode([
                'modelData' => $resourceData
            ]);
        }
        return $this;
    }
}
