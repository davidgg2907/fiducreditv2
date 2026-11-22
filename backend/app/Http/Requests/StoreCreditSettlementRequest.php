<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditSettlementRequest extends FormRequest
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
            'quote_id' => ['required', 'uuid', 'exists:credit_payoff_quotes,id'],
            'payment_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_payments,id'],
            'settlement_number' => ['required', 'string', 'max:70', Rule::unique('credit_settlements', 'settlement_number')],
            'value_date' => ['required', 'date'],
            'settled_amount' => ['required', 'numeric'],
            'status' => ['sometimes', 'string', 'max:30'],
            'completed_at' => ['sometimes', 'nullable', 'date'],
            'authorized_by' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
