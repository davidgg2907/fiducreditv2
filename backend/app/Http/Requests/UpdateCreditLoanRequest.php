<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditLoanRequest extends FormRequest
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
            'line_id' => ['sometimes', 'uuid', 'exists:credit_lines,id'],
            'drawdown_id' => ['sometimes', 'uuid', 'exists:credit_drawdowns,id', Rule::unique('credit_loans', 'drawdown_id')->ignore($this->route('id'))],
            'application_id' => ['sometimes', 'uuid', 'exists:credit_applications,id'],
            'contract_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_contracts,id'],
            'loan_number' => ['sometimes', 'string', 'max:60', Rule::unique('credit_loans', 'loan_number')->ignore($this->route('id'))],
            'status' => ['sometimes', 'string', 'max:30'],
            'currency' => ['sometimes', 'string', 'max:3'],
            'original_principal' => ['sometimes', 'numeric'],
            'principal_outstanding' => ['sometimes', 'numeric'],
            'start_date' => ['sometimes', 'date'],
            'maturity_date' => ['sometimes', 'date'],
            'term_count' => ['sometimes', 'integer'],
            'term_unit' => ['sometimes', 'string', 'max:20'],
            'last_accrual_date' => ['sometimes', 'nullable', 'date'],
            'closed_at' => ['sometimes', 'nullable', 'date'],
            'lock_version' => ['sometimes', 'integer'],
            'loan_id' => ['sometimes', 'string'],
        ];
    }
}
