<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditLoanAdjustmentRequest extends FormRequest
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
            'adjustment_number' => ['sometimes', 'string', 'max:70', Rule::unique('credit_loan_adjustments', 'adjustment_number')->ignore($this->route('id'))],
            'component' => ['sometimes', 'string', 'max:40'],
            'adjustment_type' => ['sometimes', 'string', 'max:40'],
            'amount' => ['sometimes', 'numeric'],
            'value_date' => ['sometimes', 'date'],
            'reason' => ['sometimes', 'string', 'max:250'],
            'approved_by' => ['sometimes', 'integer', 'exists:users,id'],
            'status' => ['sometimes', 'string', 'max:30'],
        ];
    }
}
