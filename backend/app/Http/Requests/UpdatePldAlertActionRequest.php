<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdatePldAlertActionRequest extends FormRequest
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
            'alert_id' => ['sometimes', 'uuid', 'exists:pld_alerts,id'],
            'actor_id' => ['sometimes', 'integer', 'exists:users,id'],
            'action' => ['sometimes', 'string', 'max:60'],
            'from_status' => ['sometimes', 'nullable', 'string', 'max:30'],
            'to_status' => ['sometimes', 'nullable', 'string', 'max:30'],
            'notes' => ['sometimes', 'nullable', 'string'],
            'occurred_at' => ['sometimes', 'date'],
        ];
    }
}
