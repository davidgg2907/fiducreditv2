<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StorePldClientProfileRequest extends FormRequest
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
            'policy_version_id' => ['required', 'uuid', 'exists:pld_policy_versions,id'],
            'risk_level' => ['required', 'string', 'max:25'],
            'occupation' => ['sometimes', 'nullable', 'string', 'max:255'],
            'economic_activity' => ['sometimes', 'nullable', 'string', 'max:255'],
            'funds_origin' => ['sometimes', 'nullable', 'string', 'max:255'],
            'expected_monthly_volume' => ['sometimes', 'nullable', 'numeric'],
            'expected_monthly_operations' => ['sometimes', 'nullable', 'integer'],
            'residency_country' => ['sometimes', 'string', 'max:2'],
            'pep_declared' => ['sometimes', 'boolean'],
            'assessed_at' => ['required', 'date'],
            'next_review_at' => ['sometimes', 'nullable', 'date'],
            'assessed_by' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
        ];
    }
}
