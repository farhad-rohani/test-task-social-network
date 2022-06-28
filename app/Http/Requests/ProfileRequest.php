<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|min:3|max:255|',
            'last_name' => 'required|min:3|max:255|',
            'description' => 'required|min:3|max:4000|',
            'image' => 'sometimes|image'
        ];

    }

    public function authorize(): bool
    {
        return true;
    }

}
