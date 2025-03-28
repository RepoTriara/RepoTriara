<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'name' => [
        'required',
        'string',
        'max:60',
        'min:5',
        'regex:/^[a-zA-ZÁÉÍÓÚáéíóúñÑ ]+$/u',
        'not_regex:/\s{2,}/',
        ],
        'email' => [
            'required',
            'string',
            'email:rfc,dns',
            'max:255',
            'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,63}$/',
            Rule::unique(User::class)->ignore($this->user()->id), // Excluye el usuario actual
        ],
        'notify' => ['nullable', 'boolean'],
        'address' => ['nullable', 'string', 'max:60'],
        'phone' => ['nullable', 'digits:10'],
        'password' => ['nullable', 'string', 'min:8'], // Password validation
    ];
}
}
