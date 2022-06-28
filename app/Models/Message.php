<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Message extends Model
{
    use HasFactory,\App\Models\lib\Media;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
