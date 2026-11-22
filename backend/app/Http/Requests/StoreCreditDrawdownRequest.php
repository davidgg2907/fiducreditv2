<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditDrawdownRequest extends FormRequest
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
            'application_id' => ['required', 'uuid', 'exists:credit_applications,id'],
            'bank_account_id' => ['required', 'uuid', 'exists:credit_client_bank_accounts,id'],
            'draw_number' => ['required', 'string', 'max:50', Rule::unique('credit_drawdowns', 'draw_number')],
            'amount' => ['required', 'numeric'],
            'status' => ['sometimes', 'string', 'max:30'],
            'value_date' => ['required', 'date'],
            'executed_at' => ['sometimes', 'nullable', 'date'],
            'external_reference' => ['sometimes', 'nullable', 'string', 'max:120'],
            'requested_by' => ['required', 'integer', 'exists:users,id'],
            'authorized_by' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
        ];
    }
}
