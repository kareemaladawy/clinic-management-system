<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
                'slot' => $this->slot,
                'specialty' => (string)$this->specialty,
            ],
        ];
    }
}
