<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'unique:users,username',
            ],
            'email' => [
                'required',
                'unique:users,email',
                'email'
            ],
            'password' => [
                'required'
            ]
        ];
    }
}
