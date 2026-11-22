<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditApplicationConsentRequest extends FormRequest
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
            'consent_type' => ['sometimes', 'string', 'max:255'],
            'version' => ['sometimes', 'string', 'max:255'],
            'accepted' => ['sometimes', 'boolean'],
            'accepted_at' => ['sometimes', 'nullable', 'date'],
            'evidence_storage_path' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }
}
