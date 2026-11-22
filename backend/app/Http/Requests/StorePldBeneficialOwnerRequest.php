<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StorePldBeneficialOwnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        if ($user?->is_superadmin !== true) {
            return false;
        }

        return in_array('pld-data.write', $user->permissions(), true);
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'uuid', 'exists:credit_clients,id'],
            'full_name' => ['required', 'string', 'max:160'],
            'relationship' => ['required', 'string', 'max:70'],
            'ownership_percentage' => ['sometimes', 'nullable', 'numeric'],
            'identification_reference' => ['sometimes', 'nullable', 'string', 'max:255'],
            'verified' => ['sometimes', 'boolean'],
            'verified_at' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
