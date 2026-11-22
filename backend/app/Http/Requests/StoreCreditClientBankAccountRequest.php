<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditClientBankAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        if ($user?->is_superadmin !== true) {
            return false;
        }

        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'uuid', 'exists:credit_clients,id'],
            'bank_code' => ['sometimes', 'nullable', 'string', 'max:5'],
            'bank_name' => ['required', 'string', 'max:255'],
            'holder_name' => ['required', 'string', 'max:255'],
            'clabe' => ['sometimes', 'nullable', 'string', 'max:18'],
            'account_last4' => ['sometimes', 'nullable', 'string', 'max:4'],
            'account_type' => ['sometimes', 'string', 'max:255'],
            'verified' => ['sometimes', 'boolean'],
            'primary' => ['sometimes', 'boolean'],
            'active' => ['sometimes', 'boolean'],
        ];
    }
}
