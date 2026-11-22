<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StorePldCaseEventRequest extends FormRequest
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
            'case_id' => ['required', 'uuid', 'exists:pld_cases,id'],
            'actor_id' => ['required', 'integer', 'exists:users,id'],
            'action' => ['required', 'string', 'max:60'],
            'notes' => ['sometimes', 'nullable', 'string'],
            'evidence_path' => ['sometimes', 'nullable', 'string', 'max:255'],
            'occurred_at' => ['required', 'date'],
        ];
    }
}
