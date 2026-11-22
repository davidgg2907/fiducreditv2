<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditSettlementRequest extends FormRequest
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
            'quote_id' => ['sometimes', 'uuid', 'exists:credit_payoff_quotes,id'],
            'payment_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_payments,id'],
            'settlement_number' => ['sometimes', 'string', 'max:70', Rule::unique('credit_settlements', 'settlement_number')->ignore($this->route('id'))],
            'value_date' => ['sometimes', 'date'],
            'settled_amount' => ['sometimes', 'numeric'],
            'status' => ['sometimes', 'string', 'max:30'],
            'completed_at' => ['sometimes', 'nullable', 'date'],
            'authorized_by' => ['sometimes', 'integer', 'exists:users,id'],
        ];
    }
}
