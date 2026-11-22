<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditLoanRequest extends FormRequest
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
            'line_id' => ['required', 'uuid', 'exists:credit_lines,id'],
            'drawdown_id' => ['required', 'uuid', 'exists:credit_drawdowns,id', Rule::unique('credit_loans', 'drawdown_id')],
            'application_id' => ['required', 'uuid', 'exists:credit_applications,id'],
            'contract_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_contracts,id'],
            'loan_number' => ['required', 'string', 'max:60', Rule::unique('credit_loans', 'loan_number')],
            'status' => ['sometimes', 'string', 'max:30'],
            'currency' => ['sometimes', 'string', 'max:3'],
            'original_principal' => ['required', 'numeric'],
            'principal_outstanding' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
            'maturity_date' => ['required', 'date'],
            'term_count' => ['required', 'integer'],
            'term_unit' => ['sometimes', 'string', 'max:20'],
            'last_accrual_date' => ['sometimes', 'nullable', 'date'],
            'closed_at' => ['sometimes', 'nullable', 'date'],
            'lock_version' => ['sometimes', 'integer'],
            'loan_id' => ['required', 'string'],
        ];
    }
}
