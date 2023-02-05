<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class SLotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'attributes' => [
                'doctor_id' => (string)$this->doctor->id,
                'doctor_name' => (string)$this->doctor->name,
                'doctor_phone_number' => (string)$this->doctor->phone_number,
                'state' => (string)$this->state,
                'date' => $this->date,
                'time' => $this->time,
            ],
        ];
    }
}
