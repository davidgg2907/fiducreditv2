<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditAmortizationScheduleRequest extends FormRequest
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
            'terms_id' => ['sometimes', 'uuid', 'exists:credit_loan_terms,id'],
            'version' => ['sometimes', 'integer'],
            'status' => ['sometimes', 'string', 'max:25'],
            'calculation_date' => ['sometimes', 'date'],
            'first_due_date' => ['sometimes', 'date'],
            'scheduled_principal' => ['sometimes', 'numeric'],
            'scheduled_interest' => ['sometimes', 'numeric'],
            'scheduled_total' => ['sometimes', 'numeric'],
            'reason' => ['sometimes', 'nullable', 'string', 'max:150'],
            'generated_by' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
        ];
    }
}
