<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Message */
class MessageResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,

            $this->mergeWhen(!$this->relationLoaded('user'), [
                'user_id' => $this->user_id,
            ]),
            'user' => new UserResource($this->whenLoaded('user')),
            'image' => new MediaResource($this->whenLoaded('image')),

        ];
    }
}
