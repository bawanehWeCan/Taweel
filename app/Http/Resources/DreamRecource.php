<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DreamRecource extends JsonResource
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
            'name' => $this->name,
            'content' => $this->content,
            'views' => $this->views,
            'category' => $this->cat->name,
            'status' => $this->status,
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'opened' => $this->opened,

            
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,

        ];
    }
}
