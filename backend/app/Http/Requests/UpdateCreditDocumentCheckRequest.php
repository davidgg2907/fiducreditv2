<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditDocumentCheckRequest extends FormRequest
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
            'application_document_id' => ['sometimes', 'uuid', 'exists:credit_application_documents,id'],
            'validation_rule_id' => ['sometimes', 'uuid', 'exists:credit_document_validation_rules,id'],
            'result' => ['sometimes', 'string', 'max:255'],
            'observations' => ['sometimes', 'nullable', 'string'],
            'checked_by' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'checked_at' => ['sometimes', 'date'],
        ];
    }
}
