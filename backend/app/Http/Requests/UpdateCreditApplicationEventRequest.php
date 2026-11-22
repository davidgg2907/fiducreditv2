<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditApplicationEventRequest extends FormRequest
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
            'application_id' => ['sometimes', 'uuid', 'exists:credit_applications,id'],
            'actor_id' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'event_type' => ['sometimes', 'string', 'max:255'],
            'before_data' => ['sometimes', 'nullable', 'array'],
            'after_data' => ['sometimes', 'nullable', 'array'],
            'ip_address' => ['sometimes', 'nullable', 'string', 'max:45'],
            'occurred_at' => ['sometimes', 'date'],
        ];
    }
}
