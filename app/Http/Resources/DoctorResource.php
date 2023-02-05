<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
                'name' => (string)$this->name,
                'email' => (string)$this->email,
                'phone_number' => $this->phone_number,
                'gender' => $this->gender,
                'specialty' => $this->specialty,
                'description' => $this->description,
                'location' => $this->location,
                'avatar' => asset('avatars/doctors/' . $this->avatar),
            ],
            'feedbacks' => [
                $this->feedbacks->map(function ($feedback) {
                    return $feedback;
                })
            ],
            'slots' => [
                $this->slots->map(function ($slot) {
                    return $slot;
                })
            ]
        ];
    }
}
