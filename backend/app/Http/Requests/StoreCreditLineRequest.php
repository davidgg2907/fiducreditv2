<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditLineRequest extends FormRequest
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
            'client_id' => ['required', 'uuid', 'exists:credit_clients,id'],
            'origin_application_id' => ['required', 'uuid', 'exists:credit_applications,id', Rule::unique('credit_lines', 'origin_application_id')],
            'product_version_id' => ['required', 'uuid', 'exists:credit_product_versions,id'],
            'policy_id' => ['required', 'uuid', 'exists:credit_line_policies,id'],
            'line_number' => ['required', 'string', 'max:50', Rule::unique('credit_lines', 'line_number')],
            'status' => ['sometimes', 'string', 'max:30'],
            'currency' => ['sometimes', 'string', 'max:3'],
            'authorized_limit' => ['required', 'numeric'],
            'committed_amount' => ['sometimes', 'numeric'],
            'outstanding_principal' => ['sometimes', 'numeric'],
            'available_amount' => ['required', 'numeric'],
            'effective_date' => ['required', 'date'],
            'expiration_date' => ['sometimes', 'nullable', 'date'],
            'authorized_by' => ['required', 'integer', 'exists:users,id'],
            'authorized_at' => ['required', 'date'],
            'lock_version' => ['sometimes', 'integer'],
        ];
    }
}
