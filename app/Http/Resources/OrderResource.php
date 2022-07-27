<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $hours = [];
        foreach ($this->hours()->get() as $item) {
            $hours[] = $item->hour;
        }
        return [
            'id' => $this->id,
            'weight' => $this->weight,
            'region_id' => $this->region_id,
            'delivery_hours' => $hours
        ];
    }
}
