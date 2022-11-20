<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobOpeningResource extends JsonResource
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
            'company id' => $this->company_id,
            'company name' => $this->company->name,
            'position'  => $this->position,
            'description' => $this->description,
            'deadline'  => $this->deadline,
            'status'    => $this->status
        ];
    }
}
