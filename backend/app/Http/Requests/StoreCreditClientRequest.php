<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditClientRequest extends FormRequest
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
            'company_id' => ['required', 'uuid', 'exists:credit_companies,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'second_last_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'birth_date' => ['sometimes', 'nullable', 'date'],
            'rfc' => ['sometimes', 'nullable', 'string', 'max:13'],
            'curp' => ['sometimes', 'nullable', 'string', 'max:18'],
            'ine_folio' => ['sometimes', 'nullable', 'string', 'max:255'],
            'passport_number' => ['sometimes', 'nullable', 'string', 'max:255'],
            'nss' => ['sometimes', 'nullable', 'string', 'max:255'],
            'health_provider' => ['sometimes', 'nullable', 'string', 'max:255'],
            'email' => ['sometimes', 'nullable', 'string', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:20'],
            'status' => ['sometimes', 'string', 'max:255'],
        ];
    }
}
