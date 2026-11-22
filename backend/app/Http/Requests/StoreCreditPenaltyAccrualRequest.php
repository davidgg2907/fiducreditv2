<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditPenaltyAccrualRequest extends FormRequest
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
            'installment_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_amortization_installments,id'],
            'period_start' => ['required', 'date'],
            'period_end' => ['required', 'date'],
            'value_date' => ['required', 'date'],
            'days_overdue' => ['required', 'integer'],
            'overdue_basis' => ['required', 'numeric'],
            'annual_rate' => ['required', 'numeric'],
            'penalty_interest' => ['required', 'numeric'],
            'tax_amount' => ['sometimes', 'numeric'],
            'calculation_key' => ['required', 'string', 'max:100', Rule::unique('credit_penalty_accruals', 'calculation_key')],
            'reversed' => ['sometimes', 'boolean'],
            'calculated_at' => ['required', 'date'],
        ];
    }
}
