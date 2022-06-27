<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index()
    {
        return auth()->user()->followings()->with('profile');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Profile $profile)
    {
        //
    }

    public function edit(Profile $profile)
    {
        //
    }

    public function update(Request $request, Profile $profile)
    {
        //
    }

    public function destroy(Profile $profile)
    {
        //
    }
}
