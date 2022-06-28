<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Profile */
class ProfileResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            $this->mergeWhen(!request()->routeIs('profile.follow*'), [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'description' => $this->description,
                $this->mergeWhen(!$this->relationLoaded('user'), [
                    'user_id' => $this->user_id,
                ]),
            ]),


            'user' => new UserResource($this->whenLoaded('user')),
            'image' => new MediaResource($this->whenLoaded('image')),

        ];
    }
}
