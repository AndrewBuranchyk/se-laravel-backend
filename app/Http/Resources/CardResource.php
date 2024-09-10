<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'department_id' => $this->department_id,
            'gr' => $this->gr,
            'el' => $this->el,
            'ms' => $this->ms,
            'rp' => $this->rp,
            'data' => $this->data,
            'department' => $this->department,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

    }
}
