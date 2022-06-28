<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AuthRequest extends FormRequest
{
    public function rules(): array
    {

        if ($this->routeIs('auth.register')) {
            $list = [
                'email' => 'required|email|unique:users,email',
                'password' => ['required', Password::default()],
                'name' => 'required|unique:users,name',
            ];
        }
        elseif ($this->routeIs('auth.login')) {
            $list = [
                'email' => 'required|email',
                'password' => 'required',
            ];
        }
        return $list;
    }

    public function authorize(): bool
    {
        return true;
    }
}
