<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(AuthRequest $request)
    {
        $request->merge(['password' => bcrypt($request->password)]);
        $user = User::create($request->only('password', 'email', 'name'));
        $user->profile()->create();
//        $user->assignRole('writer');
        $token = $user->createToken('spa');
        return ['token' => $token->plainTextToken, 'user' => new UserResource($user->load('profile'))];
    }

    public function login(AuthRequest $request)
    {
        if (auth()->attempt($request->validated())) {
            $user = auth()->user();
            $user->tokens()->whereName('spa')->delete();
            $token = $user->createToken('spa');
            return ['token' => $token->plainTextToken, 'user' => new UserResource($user->load('profile'))];
        } else {
            abort(401, 'Incorrect Login Data');
        }
    }

    public function logout()
    {
        auth()->logout();
        abort(200, 'logout successful');
    }
}
