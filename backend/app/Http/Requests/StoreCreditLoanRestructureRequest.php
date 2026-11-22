<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditLoanRestructureRequest extends FormRequest
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
            'new_terms_id' => ['required', 'uuid', 'exists:credit_loan_terms,id'],
            'new_schedule_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_amortization_schedules,id'],
            'restructure_number' => ['required', 'string', 'max:70', Rule::unique('credit_loan_restructures', 'restructure_number')],
            'reason' => ['required', 'string', 'max:200'],
            'effective_date' => ['required', 'date'],
            'status' => ['sometimes', 'string', 'max:30'],
            'approved_by' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
