<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditAmortizationInstallmentRequest extends FormRequest
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
            'schedule_id' => ['sometimes', 'uuid', 'exists:credit_amortization_schedules,id'],
            'loan_id' => ['sometimes', 'uuid', 'exists:credit_loans,id'],
            'installment_number' => ['sometimes', 'integer'],
            'period_start' => ['sometimes', 'date'],
            'due_date' => ['sometimes', 'date'],
            'opening_principal' => ['sometimes', 'numeric'],
            'principal_due' => ['sometimes', 'numeric'],
            'ordinary_interest_due' => ['sometimes', 'numeric'],
            'tax_due' => ['sometimes', 'numeric'],
            'fee_due' => ['sometimes', 'numeric'],
            'scheduled_total' => ['sometimes', 'numeric'],
            'closing_principal' => ['sometimes', 'numeric'],
            'principal_paid' => ['sometimes', 'numeric'],
            'interest_paid' => ['sometimes', 'numeric'],
            'tax_paid' => ['sometimes', 'numeric'],
            'fee_paid' => ['sometimes', 'numeric'],
            'status' => ['sometimes', 'string', 'max:25'],
        ];
    }
}
