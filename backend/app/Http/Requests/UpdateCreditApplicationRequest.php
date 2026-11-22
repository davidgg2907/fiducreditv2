<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditApplicationRequest extends FormRequest
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
            'client_id' => ['sometimes', 'uuid', 'exists:credit_clients,id'],
            'product_version_id' => ['sometimes', 'uuid', 'exists:credit_product_versions,id'],
            'advisor_id' => ['sometimes', 'uuid', 'exists:credit_advisors,id'],
            'branch_id' => ['sometimes', 'uuid', 'exists:credit_branches,id'],
            'address_version_id' => ['sometimes', 'uuid', 'exists:credit_client_address_versions,id'],
            'bank_account_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_client_bank_accounts,id'],
            'previous_application_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_applications,id'],
            'application_number' => ['sometimes', 'string', 'max:255', Rule::unique('credit_applications', 'application_number')->ignore($this->route('id'))],
            'version' => ['sometimes', 'integer'],
            'requested_amount' => ['sometimes', 'numeric'],
            'approved_amount' => ['sometimes', 'nullable', 'numeric'],
            'requested_term' => ['sometimes', 'integer'],
            'status' => ['sometimes', 'string', 'max:255'],
            'review_substatus' => ['sometimes', 'nullable', 'string', 'max:255'],
            'product_snapshot' => ['sometimes', 'nullable', 'array'],
            'declared_income' => ['sometimes', 'nullable', 'numeric'],
            'declared_expenses' => ['sometimes', 'nullable', 'numeric'],
            'debt_to_income_ratio' => ['sometimes', 'nullable', 'numeric'],
            'submitted_at' => ['sometimes', 'nullable', 'date'],
            'decided_at' => ['sometimes', 'nullable', 'date'],
            'created_by' => ['sometimes', 'integer', 'exists:users,id'],
        ];
    }
}
