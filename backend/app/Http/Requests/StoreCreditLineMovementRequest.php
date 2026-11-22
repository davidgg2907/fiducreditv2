<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditLineMovementRequest extends FormRequest
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
            'movement_type' => ['required', 'string', 'max:40'],
            'amount' => ['required', 'numeric'],
            'available_before' => ['required', 'numeric'],
            'available_after' => ['required', 'numeric'],
            'loan_id' => ['sometimes', 'nullable', 'uuid'],
            'reference' => ['required', 'string', 'max:100', Rule::unique('credit_line_movements', 'reference')],
            'value_date' => ['required', 'date'],
            'recorded_at' => ['required', 'date'],
            'created_by' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'metadata' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
