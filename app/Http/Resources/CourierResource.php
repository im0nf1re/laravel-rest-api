<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $regions = [];
        foreach ($this->regions()->get() as $item) {
            $regions[] = $item->id;
        }
        $hours = [];
        foreach ($this->hours()->get() as $item) {
            $hours[] = $item->hour;
        }
        return [
            'id' => $this->id,
            'courier_type' => $this->courier_type,
            'regions' => $regions,
            'working_hours' => $hours
        ];
    }
}
