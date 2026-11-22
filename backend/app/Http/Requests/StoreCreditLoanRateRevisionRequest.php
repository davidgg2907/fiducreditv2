<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditLoanRateRevisionRequest extends FormRequest
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
            'loan_id' => ['required', 'uuid', 'exists:credit_loans,id'],
            'terms_id' => ['required', 'uuid', 'exists:credit_loan_terms,id'],
            'effective_date' => ['required', 'date'],
            'previous_annual_rate' => ['sometimes', 'nullable', 'numeric'],
            'new_annual_rate' => ['required', 'numeric'],
            'rate_reference' => ['sometimes', 'nullable', 'string', 'max:100'],
            'reason' => ['sometimes', 'nullable', 'string'],
            'authorized_by' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
