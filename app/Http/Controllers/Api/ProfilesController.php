<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Lib\Lib;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\RelationResource;
use App\Http\Resources\UserResource;
use App\Models\Profile;
use App\Models\Relation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfilesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Profile::class, 'profile', [
            'except' => ['index'],
        ]);
    }


    public function store(ProfileRequest $request)
    {
        $profile = auth()->user()->profile()->firstOrCreate($request->only('first_name', 'last_name', 'description'));
        if (!$profile->image && $request->image) $profile->storeImage($request->image);
        return new ProfileResource($profile->load('user', 'image'));
    }


    public function show(Profile $profile)
    {
        return new ProfileResource($profile->load('user', 'image'));
    }


    public function update(ProfileRequest $request, Profile $profile)
    {
        $profile->update($request->only('first_name', 'last_name', 'description'));
        if ($request->image) {
            $profile->deleteImage();
            $profile->storeImage($request->image);
        }
        return new ProfileResource($profile->load('user', 'image'));
    }

    public function destroy(Profile $profile)
    {
        $profile->deleteImage();
        $profile->delete();
    }


}
