<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditInterestAccrualRequest extends FormRequest
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
            'period_start' => ['sometimes', 'date'],
            'period_end' => ['sometimes', 'date'],
            'value_date' => ['sometimes', 'date'],
            'accrual_days' => ['sometimes', 'integer'],
            'principal_basis' => ['sometimes', 'numeric'],
            'annual_rate' => ['sometimes', 'numeric'],
            'interest_amount' => ['sometimes', 'numeric'],
            'tax_amount' => ['sometimes', 'numeric'],
            'calculation_key' => ['sometimes', 'string', 'max:100', Rule::unique('credit_interest_accruals', 'calculation_key')->ignore($this->route('id'))],
            'reversed' => ['sometimes', 'boolean'],
            'calculated_at' => ['sometimes', 'date'],
        ];
    }
}
