<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    use HasFactory,\App\Models\lib\Media;

    protected $fillable = [
        'description', 'first_name', 'last_name'
    ];


    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
