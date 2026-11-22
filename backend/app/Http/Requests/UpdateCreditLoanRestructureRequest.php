<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditLoanRestructureRequest extends FormRequest
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
            'new_terms_id' => ['sometimes', 'uuid', 'exists:credit_loan_terms,id'],
            'new_schedule_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_amortization_schedules,id'],
            'restructure_number' => ['sometimes', 'string', 'max:70', Rule::unique('credit_loan_restructures', 'restructure_number')->ignore($this->route('id'))],
            'reason' => ['sometimes', 'string', 'max:200'],
            'effective_date' => ['sometimes', 'date'],
            'status' => ['sometimes', 'string', 'max:30'],
            'approved_by' => ['sometimes', 'integer', 'exists:users,id'],
        ];
    }
}
