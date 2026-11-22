<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditApplicationConsentRequest extends FormRequest
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
            'consent_type' => ['required', 'string', 'max:255'],
            'version' => ['required', 'string', 'max:255'],
            'accepted' => ['required', 'boolean'],
            'accepted_at' => ['sometimes', 'nullable', 'date'],
            'evidence_storage_path' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }
}
