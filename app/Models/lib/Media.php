<?php

namespace App\Models\lib;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

trait Media
{

    public function storeImage($file): string|bool
    {
        /**
         * @var $file UploadedFile
         */
        DB::beginTransaction();
        $media = $this->image()->create([
            'name' => $file->getClientOriginalName(),
            'file_name' => $file->hashName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);

        $put = Storage::disk('public')->put($media->folder, $file);
        if ($put) {
            DB::commit();
            return $media->url;
        } else {
            DB::rollBack();
            return false;
        }
    }

    public function deleteImage(): bool
    {
        $media = $this->image;
        if (!$media) return false;

        $path = $media->model_type . '/' . $media->model_id . '/' . $media->file_name;
        DB::beginTransaction();

        if (!$media->delete()) {
            DB::rollBack();
            return false;
        }

        $delete = Storage::disk('public')->delete($path);
        if ($delete) {
            DB::commit();
            return true;
        } else {
            DB::rollBack();
            return false;
        }

    }

    public function image(): MorphOne
    {
        return $this->morphOne(\App\Models\Media::class, 'model');
    }
}
