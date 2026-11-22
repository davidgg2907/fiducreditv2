<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditLoanLedgerEntryRequest extends FormRequest
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
            'payment_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_payments,id'],
            'drawdown_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_drawdowns,id'],
            'entry_number' => ['required', 'string', 'max:90', Rule::unique('credit_loan_ledger_entries', 'entry_number')],
            'entry_type' => ['required', 'string', 'max:50'],
            'component' => ['required', 'string', 'max:35'],
            'direction' => ['required', 'string', 'max:6'],
            'amount' => ['required', 'numeric'],
            'currency' => ['sometimes', 'string', 'max:3'],
            'value_date' => ['required', 'date'],
            'posted_at' => ['required', 'date'],
            'reversal_of_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_loan_ledger_entries,id'],
            'idempotency_key' => ['required', 'string', 'max:120', Rule::unique('credit_loan_ledger_entries', 'idempotency_key')],
            'metadata' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
