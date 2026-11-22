<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditPaymentRequest extends FormRequest
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
            'line_id' => ['sometimes', 'uuid', 'exists:credit_lines,id'],
            'channel_id' => ['sometimes', 'uuid', 'exists:credit_payment_channels,id'],
            'source_bank_account_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_client_bank_accounts,id'],
            'payment_number' => ['sometimes', 'string', 'max:70', Rule::unique('credit_payments', 'payment_number')->ignore($this->route('id'))],
            'external_reference' => ['sometimes', 'nullable', 'string', 'max:120'],
            'amount' => ['sometimes', 'numeric'],
            'currency' => ['sometimes', 'string', 'max:3'],
            'value_date' => ['sometimes', 'date'],
            'received_at' => ['sometimes', 'date'],
            'posted_at' => ['sometimes', 'nullable', 'date'],
            'status' => ['sometimes', 'string', 'max:30'],
            'third_party' => ['sometimes', 'boolean'],
            'payer_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'recorded_by' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
        ];
    }
}
