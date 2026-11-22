<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditLoanAdjustmentRequest extends FormRequest
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
            'adjustment_number' => ['required', 'string', 'max:70', Rule::unique('credit_loan_adjustments', 'adjustment_number')],
            'component' => ['required', 'string', 'max:40'],
            'adjustment_type' => ['required', 'string', 'max:40'],
            'amount' => ['required', 'numeric'],
            'value_date' => ['required', 'date'],
            'reason' => ['required', 'string', 'max:250'],
            'approved_by' => ['required', 'integer', 'exists:users,id'],
            'status' => ['sometimes', 'string', 'max:30'],
        ];
    }
}
