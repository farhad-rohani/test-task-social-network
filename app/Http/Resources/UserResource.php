<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class UserResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'messages' => MessageResource::collection($this->whenLoaded('messages')),
            'profile' => new ProfileResource($this->whenLoaded('profile')),
            'image' => new MediaResource($this->whenLoaded('image')),
            'followers' => UserResource::collection($this->whenLoaded('followers')),
            'followings' => UserResource::collection($this->whenLoaded('followings')),

        ];
    }
}
