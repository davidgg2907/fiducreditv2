<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditApplicationDecisionRequest extends FormRequest
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
            'decided_by' => ['required', 'integer', 'exists:users,id'],
            'decision' => ['required', 'string', 'max:255'],
            'approved_amount' => ['sometimes', 'nullable', 'numeric'],
            'reason' => ['sometimes', 'nullable', 'string'],
            'decided_at' => ['required', 'date'],
        ];
    }
}
