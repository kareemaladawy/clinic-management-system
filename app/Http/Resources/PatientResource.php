<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
                'avatar' => asset('avatars/patients/' . $this->avatar),
                'birthday' => $this->birthday,
                'location' => $this->location,
            ],
            'appointments' => [
                $this->appointments
            ],
            'diagnosis' => [
                $this->diagnosis
            ]
        ];
    }
}
