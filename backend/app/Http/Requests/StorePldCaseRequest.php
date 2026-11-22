<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StorePldCaseRequest extends FormRequest
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
            'company_id' => ['required', 'uuid', 'exists:credit_companies,id'],
            'client_id' => ['required', 'uuid', 'exists:credit_clients,id'],
            'source_alert_id' => ['required', 'uuid', 'exists:pld_alerts,id'],
            'case_number' => ['required', 'string', 'max:70', Rule::unique('pld_cases', 'case_number')],
            'status' => ['sometimes', 'string', 'max:30'],
            'risk_level' => ['required', 'string', 'max:20'],
            'compliance_officer_id' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'opened_at' => ['required', 'date'],
            'closed_at' => ['sometimes', 'nullable', 'date'],
            'resolution' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
