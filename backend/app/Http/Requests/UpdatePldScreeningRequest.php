<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdatePldScreeningRequest extends FormRequest
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
            'loan_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_loans,id'],
            'screening_type' => ['sometimes', 'string', 'max:50'],
            'provider' => ['sometimes', 'string', 'max:100'],
            'list_version' => ['sometimes', 'nullable', 'string', 'max:100'],
            'result' => ['sometimes', 'string', 'max:30'],
            'external_reference' => ['sometimes', 'nullable', 'string', 'max:150'],
            'evidence_path' => ['sometimes', 'nullable', 'string', 'max:255'],
            'screened_at' => ['sometimes', 'date'],
            'reviewed_by' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
        ];
    }
}
