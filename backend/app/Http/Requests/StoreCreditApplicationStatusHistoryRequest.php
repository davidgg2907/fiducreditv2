<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditApplicationStatusHistoryRequest extends FormRequest
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
            'application_id' => ['required', 'uuid', 'exists:credit_applications,id'],
            'from_status' => ['sometimes', 'nullable', 'string', 'max:255'],
            'to_status' => ['required', 'string', 'max:255'],
            'from_substatus' => ['sometimes', 'nullable', 'string', 'max:255'],
            'to_substatus' => ['sometimes', 'nullable', 'string', 'max:255'],
            'reason' => ['sometimes', 'nullable', 'string'],
            'changed_by' => ['required', 'integer', 'exists:users,id'],
            'changed_at' => ['required', 'date'],
        ];
    }
}
