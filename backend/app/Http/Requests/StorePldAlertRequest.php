<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StorePldAlertRequest extends FormRequest
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
            'monitoring_event_id' => ['required', 'uuid', 'exists:pld_monitoring_events,id'],
            'rule_id' => ['required', 'uuid', 'exists:pld_rules,id'],
            'client_id' => ['required', 'uuid', 'exists:credit_clients,id'],
            'alert_number' => ['required', 'string', 'max:70', Rule::unique('pld_alerts', 'alert_number')],
            'severity' => ['required', 'string', 'max:20'],
            'status' => ['sometimes', 'string', 'max:30'],
            'reason' => ['required', 'string', 'max:250'],
            'evidence' => ['sometimes', 'nullable', 'array'],
            'detected_at' => ['required', 'date'],
            'assigned_to' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'resolved_at' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
