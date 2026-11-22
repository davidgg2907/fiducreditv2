<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditLineLimitHistoryRequest extends FormRequest
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
            'previous_limit' => ['required', 'numeric'],
            'new_limit' => ['required', 'numeric'],
            'reason' => ['required', 'string', 'max:200'],
            'source_application_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_applications,id'],
            'authorized_by' => ['required', 'integer', 'exists:users,id'],
            'effective_at' => ['required', 'date'],
        ];
    }
}
