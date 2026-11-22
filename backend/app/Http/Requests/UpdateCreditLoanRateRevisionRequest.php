<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditLoanRateRevisionRequest extends FormRequest
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
            'loan_id' => ['sometimes', 'uuid', 'exists:credit_loans,id'],
            'terms_id' => ['sometimes', 'uuid', 'exists:credit_loan_terms,id'],
            'effective_date' => ['sometimes', 'date'],
            'previous_annual_rate' => ['sometimes', 'nullable', 'numeric'],
            'new_annual_rate' => ['sometimes', 'numeric'],
            'rate_reference' => ['sometimes', 'nullable', 'string', 'max:100'],
            'reason' => ['sometimes', 'nullable', 'string'],
            'authorized_by' => ['sometimes', 'integer', 'exists:users,id'],
        ];
    }
}
