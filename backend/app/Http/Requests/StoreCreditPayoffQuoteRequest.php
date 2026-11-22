<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditPayoffQuoteRequest extends FormRequest
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
            'quote_number' => ['required', 'string', 'max:70', Rule::unique('credit_payoff_quotes', 'quote_number')],
            'value_date' => ['required', 'date'],
            'expires_at' => ['required', 'date'],
            'principal_amount' => ['required', 'numeric'],
            'interest_amount' => ['required', 'numeric'],
            'penalty_amount' => ['required', 'numeric'],
            'tax_amount' => ['required', 'numeric'],
            'fees_amount' => ['required', 'numeric'],
            'credits_amount' => ['sometimes', 'numeric'],
            'total_to_settle' => ['required', 'numeric'],
            'status' => ['sometimes', 'string', 'max:30'],
            'generated_by' => ['required', 'integer', 'exists:users,id'],
            'calculation_snapshot' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
