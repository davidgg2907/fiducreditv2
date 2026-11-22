<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditLineRequest extends FormRequest
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
            'company_id' => ['sometimes', 'uuid', 'exists:credit_companies,id'],
            'client_id' => ['sometimes', 'uuid', 'exists:credit_clients,id'],
            'origin_application_id' => ['sometimes', 'uuid', 'exists:credit_applications,id', Rule::unique('credit_lines', 'origin_application_id')->ignore($this->route('id'))],
            'product_version_id' => ['sometimes', 'uuid', 'exists:credit_product_versions,id'],
            'policy_id' => ['sometimes', 'uuid', 'exists:credit_line_policies,id'],
            'line_number' => ['sometimes', 'string', 'max:50', Rule::unique('credit_lines', 'line_number')->ignore($this->route('id'))],
            'status' => ['sometimes', 'string', 'max:30'],
            'currency' => ['sometimes', 'string', 'max:3'],
            'authorized_limit' => ['sometimes', 'numeric'],
            'committed_amount' => ['sometimes', 'numeric'],
            'outstanding_principal' => ['sometimes', 'numeric'],
            'available_amount' => ['sometimes', 'numeric'],
            'effective_date' => ['sometimes', 'date'],
            'expiration_date' => ['sometimes', 'nullable', 'date'],
            'authorized_by' => ['sometimes', 'integer', 'exists:users,id'],
            'authorized_at' => ['sometimes', 'date'],
            'lock_version' => ['sometimes', 'integer'],
        ];
    }
}
