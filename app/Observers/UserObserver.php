<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Log, User};

class UserObserver
{
    protected string $event;
    protected string $otherData;
    protected array $fields = ['id', 'email', 'role', 'department_id'];

    /**
     * Handle the User "created" event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user): void
    {
        $this->event = "created";
        $this->setOtherDataField($user)
            ->logEventForResource($user);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  User  $user
     * @return void
     */
    public function updated(User $user): void
    {
        $this->event = "updated";
        $this->setOtherDataField($user)
            ->logEventForResource($user);
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  User  $user
     * @return void
     */
    public function deleted(User $user): void
    {
        $this->event = "deleted";
        $this->setOtherDataField($user)
            ->logEventForResource($user);
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
            'model' => 'User',
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
