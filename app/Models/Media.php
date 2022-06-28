<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file_name',
        'mime_type',
        'size',
    ];
    protected $appends = ['url'];

    public function mediaable()
    {
        return $this->morphTo('model');
    }

    public function getUrlAttribute()
    {
        return asset('storage' . '/' . $this->path);
    }

    public function getPathAttribute()
    {
        return  $this->folder. '/' . $this->file_name;
    }

    public function getFolderAttribute()
    {
        return  $this->model_type . '/' . $this->model_id ;
    }
}
