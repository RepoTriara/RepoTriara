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
            ],
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:60',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,63}$/',
                Rule::unique(User::class)->ignore($this->user()->id), // Excluye el usuario actual
            ],
            'notify' => ['nullable', 'boolean'],
            'address' => ['nullable', 'string', 'max:60','min:5'],
            'phone' => ['nullable', 'digits_between:7,10'],
            'password' => ['nullable', 'string', 'min:8', 'regex:/^[a-zA-Z0-9!@#$%^&*()_+\-=\[\]{};:"\'\\\\|,.<>\/?`~]+$/'],

        ];
}
   
}
