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
            'application_number' => ['sometimes', 'string', 'max:255', Rule::unique('credit_applications', 'application_number')->ignore($this->route('id'))],
            'requested_amount' => ['sometimes', 'numeric'],
            'requested_term' => ['sometimes', 'integer'],
            'declared_income' => ['sometimes', 'nullable', 'numeric'],
            'declared_expenses' => ['sometimes', 'nullable', 'numeric'],
        ];
    }
}
