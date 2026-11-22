<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StorePldMonitoringEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        if ($user?->is_superadmin !== true) {
            return false;
        }

        return in_array('pld-data.write', $user->permissions(), true);
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'uuid', 'exists:credit_clients,id'],
            'line_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_lines,id'],
            'loan_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_loans,id'],
            'payment_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_payments,id'],
            'drawdown_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_drawdowns,id'],
            'settlement_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_settlements,id'],
            'policy_version_id' => ['required', 'uuid', 'exists:pld_policy_versions,id'],
            'event_key' => ['required', 'string', 'max:120', Rule::unique('pld_monitoring_events', 'event_key')],
            'event_type' => ['required', 'string', 'max:50'],
            'amount' => ['sometimes', 'nullable', 'numeric'],
            'currency' => ['sometimes', 'string', 'max:3'],
            'value_date' => ['required', 'date'],
            'observed_at' => ['required', 'date'],
            'facts' => ['sometimes', 'nullable', 'array'],
            'evaluation_status' => ['sometimes', 'string', 'max:30'],
        ];
    }
}
