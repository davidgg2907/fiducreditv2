<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdatePldCaseRequest extends FormRequest
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
            'company_id' => ['sometimes', 'uuid', 'exists:credit_companies,id'],
            'client_id' => ['sometimes', 'uuid', 'exists:credit_clients,id'],
            'source_alert_id' => ['sometimes', 'uuid', 'exists:pld_alerts,id'],
            'case_number' => ['sometimes', 'string', 'max:70', Rule::unique('pld_cases', 'case_number')->ignore($this->route('id'))],
            'status' => ['sometimes', 'string', 'max:30'],
            'risk_level' => ['sometimes', 'string', 'max:20'],
            'compliance_officer_id' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'opened_at' => ['sometimes', 'date'],
            'closed_at' => ['sometimes', 'nullable', 'date'],
            'resolution' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
