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
        $stage = $this->stage;
        if($stage != null){
            $stage = $stage->name;
        }

        return [
            'id' => $this->id,
            'job opening id' => $this->job_opening_id,
            'job opening position' => $this->job_opening->position,
            'user id' => $user->id,
            'user first name' => $user->first_name,
            'user last name' => $user->last_name,
            'stage' => $stage,
            'status' => $this->status
        ];
    }
}
