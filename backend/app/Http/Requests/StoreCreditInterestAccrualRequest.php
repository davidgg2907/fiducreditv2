<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditInterestAccrualRequest extends FormRequest
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
            'period_start' => ['required', 'date'],
            'period_end' => ['required', 'date'],
            'value_date' => ['required', 'date'],
            'accrual_days' => ['required', 'integer'],
            'principal_basis' => ['required', 'numeric'],
            'annual_rate' => ['required', 'numeric'],
            'interest_amount' => ['required', 'numeric'],
            'tax_amount' => ['sometimes', 'numeric'],
            'calculation_key' => ['required', 'string', 'max:100', Rule::unique('credit_interest_accruals', 'calculation_key')],
            'reversed' => ['sometimes', 'boolean'],
            'calculated_at' => ['required', 'date'],
        ];
    }
}
