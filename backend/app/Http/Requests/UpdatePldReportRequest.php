<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdatePldReportRequest extends FormRequest
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
            'case_id' => ['sometimes', 'uuid', 'exists:pld_cases,id'],
            'company_id' => ['sometimes', 'uuid', 'exists:credit_companies,id'],
            'report_type' => ['sometimes', 'string', 'max:50'],
            'regulatory_regime' => ['sometimes', 'string', 'max:60'],
            'status' => ['sometimes', 'string', 'max:30'],
            'external_folio' => ['sometimes', 'nullable', 'string', 'max:120'],
            'due_at' => ['sometimes', 'nullable', 'date'],
            'submitted_at' => ['sometimes', 'nullable', 'date'],
            'evidence_path' => ['sometimes', 'nullable', 'string', 'max:255'],
            'prepared_by' => ['sometimes', 'integer', 'exists:users,id'],
        ];
    }
}
