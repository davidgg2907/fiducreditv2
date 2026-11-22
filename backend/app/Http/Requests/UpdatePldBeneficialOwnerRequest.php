<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdatePldBeneficialOwnerRequest extends FormRequest
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
            'client_id' => ['sometimes', 'uuid', 'exists:credit_clients,id'],
            'full_name' => ['sometimes', 'string', 'max:160'],
            'relationship' => ['sometimes', 'string', 'max:70'],
            'ownership_percentage' => ['sometimes', 'nullable', 'numeric'],
            'identification_reference' => ['sometimes', 'nullable', 'string', 'max:255'],
            'verified' => ['sometimes', 'boolean'],
            'verified_at' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
