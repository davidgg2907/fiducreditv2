<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditLoanEventRequest extends FormRequest
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
            'actor_id' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'event_type' => ['required', 'string', 'max:70'],
            'previous_status' => ['sometimes', 'nullable', 'string', 'max:30'],
            'new_status' => ['sometimes', 'nullable', 'string', 'max:30'],
            'payload' => ['sometimes', 'nullable', 'array'],
            'correlation_id' => ['sometimes', 'nullable', 'string', 'max:100'],
            'occurred_at' => ['required', 'date'],
        ];
    }
}
