<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pseudo' => [
                'nullable',
                'string',
                'between:2,20'
            ],
            'username' => [
                Rule::unique('users', 'username')->ignore($this->user)
            ],
            'email' => [
                Rule::unique('users', 'email')->ignore($this->user),
                'email'
            ],
        ];
    }
}
