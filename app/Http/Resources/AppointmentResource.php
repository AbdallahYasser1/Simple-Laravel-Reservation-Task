<?php

namespace App\Http\Resources;

use App\Models\User;
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

            'patient_id' => $this->user_id,
            'patient_name' => User::find($this->user_id)->name,
            'doctor_id' => $this->doctor_id,
            'doctor_name' => User::find($this->doctor_id)->name,
            'date' => $this->date,
            'start_time' => $this->start_time,

        ];
    }
}
