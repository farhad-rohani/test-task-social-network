<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
    ];

    public function image(): MorphOne
    {
        return $this->morphOne(Media::class, 'model');
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
