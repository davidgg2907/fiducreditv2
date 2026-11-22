<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditPenaltyAccrualRequest extends FormRequest
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
            'installment_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_amortization_installments,id'],
            'period_start' => ['sometimes', 'date'],
            'period_end' => ['sometimes', 'date'],
            'value_date' => ['sometimes', 'date'],
            'days_overdue' => ['sometimes', 'integer'],
            'overdue_basis' => ['sometimes', 'numeric'],
            'annual_rate' => ['sometimes', 'numeric'],
            'penalty_interest' => ['sometimes', 'numeric'],
            'tax_amount' => ['sometimes', 'numeric'],
            'calculation_key' => ['sometimes', 'string', 'max:100', Rule::unique('credit_penalty_accruals', 'calculation_key')->ignore($this->route('id'))],
            'reversed' => ['sometimes', 'boolean'],
            'calculated_at' => ['sometimes', 'date'],
        ];
    }
}
