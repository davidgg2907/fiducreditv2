<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditLoanLedgerEntryRequest extends FormRequest
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
            'payment_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_payments,id'],
            'drawdown_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_drawdowns,id'],
            'entry_number' => ['sometimes', 'string', 'max:90', Rule::unique('credit_loan_ledger_entries', 'entry_number')->ignore($this->route('id'))],
            'entry_type' => ['sometimes', 'string', 'max:50'],
            'component' => ['sometimes', 'string', 'max:35'],
            'direction' => ['sometimes', 'string', 'max:6'],
            'amount' => ['sometimes', 'numeric'],
            'currency' => ['sometimes', 'string', 'max:3'],
            'value_date' => ['sometimes', 'date'],
            'posted_at' => ['sometimes', 'date'],
            'reversal_of_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_loan_ledger_entries,id'],
            'idempotency_key' => ['sometimes', 'string', 'max:120', Rule::unique('credit_loan_ledger_entries', 'idempotency_key')->ignore($this->route('id'))],
            'metadata' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
