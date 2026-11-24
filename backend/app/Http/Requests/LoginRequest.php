<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', PasswordRules::maximumBytes()],
            'remember' => ['sometimes', 'boolean'],
            'replace_session' => ['sometimes', 'boolean'],
            'mfa_code' => ['nullable', 'string', 'digits:6'],
        ];
    }
}
