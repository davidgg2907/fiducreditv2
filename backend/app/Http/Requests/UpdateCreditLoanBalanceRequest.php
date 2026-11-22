<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditLoanBalanceRequest extends FormRequest
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
            'loan_id' => ['sometimes', 'uuid', 'exists:credit_loans,id', Rule::unique('credit_loan_balances', 'loan_id')->ignore($this->route('id'))],
            'principal_due' => ['sometimes', 'numeric'],
            'ordinary_interest_due' => ['sometimes', 'numeric'],
            'penalty_interest_due' => ['sometimes', 'numeric'],
            'tax_due' => ['sometimes', 'numeric'],
            'fee_due' => ['sometimes', 'numeric'],
            'unapplied_payments' => ['sometimes', 'numeric'],
            'total_due' => ['sometimes', 'numeric'],
            'as_of_date' => ['sometimes', 'date'],
            'lock_version' => ['sometimes', 'integer'],
        ];
    }
}
