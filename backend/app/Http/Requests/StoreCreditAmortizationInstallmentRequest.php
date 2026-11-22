<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditAmortizationInstallmentRequest extends FormRequest
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
            'schedule_id' => ['required', 'uuid', 'exists:credit_amortization_schedules,id'],
            'loan_id' => ['required', 'uuid', 'exists:credit_loans,id'],
            'installment_number' => ['required', 'integer'],
            'period_start' => ['required', 'date'],
            'due_date' => ['required', 'date'],
            'opening_principal' => ['required', 'numeric'],
            'principal_due' => ['required', 'numeric'],
            'ordinary_interest_due' => ['required', 'numeric'],
            'tax_due' => ['sometimes', 'numeric'],
            'fee_due' => ['sometimes', 'numeric'],
            'scheduled_total' => ['required', 'numeric'],
            'closing_principal' => ['required', 'numeric'],
            'principal_paid' => ['sometimes', 'numeric'],
            'interest_paid' => ['sometimes', 'numeric'],
            'tax_paid' => ['sometimes', 'numeric'],
            'fee_paid' => ['sometimes', 'numeric'],
            'status' => ['sometimes', 'string', 'max:25'],
        ];
    }
}
