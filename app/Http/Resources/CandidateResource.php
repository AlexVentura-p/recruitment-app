<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = $this->user;

        return [
            'id' => $this->id,
            'job opening id' => $this->job_opening_id,
            'job opening position' => $this->job_opening->position,
            'user id' => $user->id,
            'user first name' => $user->first_name,
            'user last name' => $user->last_name,
            'stage' => $this->stage->name,
            'status' => $this->status
        ];
    }
}
