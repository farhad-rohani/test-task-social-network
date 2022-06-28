<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Relation extends Model
{

    public function follower(): BelongsTo
    {
        return $this->BelongsTo(User::class,'follower_id');
    }

    public function following(): BelongsTo
    {
        return $this->BelongsTo(User::class,'following_id');
    }
}
