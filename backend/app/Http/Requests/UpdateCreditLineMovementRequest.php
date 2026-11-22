<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditLineMovementRequest extends FormRequest
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
            'line_id' => ['sometimes', 'uuid', 'exists:credit_lines,id'],
            'movement_type' => ['sometimes', 'string', 'max:40'],
            'amount' => ['sometimes', 'numeric'],
            'available_before' => ['sometimes', 'numeric'],
            'available_after' => ['sometimes', 'numeric'],
            'loan_id' => ['sometimes', 'nullable', 'uuid'],
            'reference' => ['sometimes', 'string', 'max:100', Rule::unique('credit_line_movements', 'reference')->ignore($this->route('id'))],
            'value_date' => ['sometimes', 'date'],
            'recorded_at' => ['sometimes', 'date'],
            'created_by' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'metadata' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
