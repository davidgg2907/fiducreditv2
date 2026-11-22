<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditPayoffQuoteRequest extends FormRequest
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
            'quote_number' => ['sometimes', 'string', 'max:70', Rule::unique('credit_payoff_quotes', 'quote_number')->ignore($this->route('id'))],
            'value_date' => ['sometimes', 'date'],
            'expires_at' => ['sometimes', 'date'],
            'principal_amount' => ['sometimes', 'numeric'],
            'interest_amount' => ['sometimes', 'numeric'],
            'penalty_amount' => ['sometimes', 'numeric'],
            'tax_amount' => ['sometimes', 'numeric'],
            'fees_amount' => ['sometimes', 'numeric'],
            'credits_amount' => ['sometimes', 'numeric'],
            'total_to_settle' => ['sometimes', 'numeric'],
            'status' => ['sometimes', 'string', 'max:30'],
            'generated_by' => ['sometimes', 'integer', 'exists:users,id'],
            'calculation_snapshot' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
