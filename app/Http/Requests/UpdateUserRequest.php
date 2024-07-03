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
            'avatar' => 'nullable|file',
            'pseudo' => [
                'nullable',
                'string',
                'between:2,20'
            ],
            'username' => [
                Rule::unique('users', 'username')->ignore($this->user)
            ],
            'bio' => 'nullable|string|between:2,400',
            'email' => [
                Rule::unique('users', 'email')->ignore($this->user),
                'email'
            ],
            'favorite_anime' => 'nullable|string',
            'favorite_manga' => 'nullable|string',
            'favorite_webtoon' => 'nullable|string'
        ];
    }
}
