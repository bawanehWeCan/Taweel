<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExplainRecource extends JsonResource
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
            

            'age' => $this->age,
            'sex' => $this->sex,
            'social_status' => $this->social_status,
            'health_status' => $this->health_status,
            'physical_condition' => $this->physical_condition,
            'kids' => $this->kids,
            'time' => $this->time,
            'brothers' => $this->brothers,
            'opened' => $this->opened,
            'admin_replay' => $this->replays->where('side','left')->first(),

            //'points' => \Auth::user()->points,
            
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,

        ];
    }
}
