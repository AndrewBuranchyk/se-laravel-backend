<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Log, Department};

class DepartmentObserver
{
    protected string $event;
    protected string $otherData;
    protected array $fields = ['id', 'name'];

    /**
     * Handle the Department "created" event.
     *
     * @param  Department  $department
     * @return void
     */
    public function created(Department $department): void
    {
        $this->event = "created";
        $this->setOtherDataField($department)
            ->logEventForResource($department);
    }

    /**
     * Handle the Department "updated" event.
     *
     * @param  Department  $department
     * @return void
     */
    public function updated(Department $department): void
    {
        $this->event = "updated";
        $this->setOtherDataField($department)
            ->logEventForResource($department);
    }

    /**
     * Handle the Department "deleted" event.
     *
     * @param  Department  $department
     * @return void
     */
    public function deleted(Department $department): void
    {
        $this->event = "deleted";
        $this->setOtherDataField($department)
            ->logEventForResource($department);
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
            'model' => 'Department',
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
