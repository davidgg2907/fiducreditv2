<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditAmortizationScheduleRequest extends FormRequest
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
            'version' => ['required', 'integer'],
            'status' => ['sometimes', 'string', 'max:25'],
            'calculation_date' => ['required', 'date'],
            'first_due_date' => ['required', 'date'],
            'scheduled_principal' => ['required', 'numeric'],
            'scheduled_interest' => ['required', 'numeric'],
            'scheduled_total' => ['required', 'numeric'],
            'reason' => ['sometimes', 'nullable', 'string', 'max:150'],
            'generated_by' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
        ];
    }
}
