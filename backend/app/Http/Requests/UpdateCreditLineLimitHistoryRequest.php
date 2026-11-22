<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditLineLimitHistoryRequest extends FormRequest
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
            'previous_limit' => ['sometimes', 'numeric'],
            'new_limit' => ['sometimes', 'numeric'],
            'reason' => ['sometimes', 'string', 'max:200'],
            'source_application_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_applications,id'],
            'authorized_by' => ['sometimes', 'integer', 'exists:users,id'],
            'effective_at' => ['sometimes', 'date'],
        ];
    }
}
