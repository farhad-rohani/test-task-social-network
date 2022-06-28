<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Relation */
class RelationResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
//            'id' => $this->id,
            'approved_at' => $this->approved_at,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,

//            'follower_id' => $this->follower_id,
//            'following_id' => $this->following_id,

            'follower' => new UserResource($this->whenLoaded('follower')),
            'following' => new UserResource($this->whenLoaded('following')),
        ];
    }
}
