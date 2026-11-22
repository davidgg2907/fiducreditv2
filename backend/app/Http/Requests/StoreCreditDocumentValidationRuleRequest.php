<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditDocumentValidationRuleRequest extends FormRequest
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
            'document_type_id' => ['required', 'uuid', 'exists:credit_document_types,id'],
            'rule_code' => ['required', 'string', 'max:255'],
            'rule_type' => ['required', 'string', 'max:255'],
            'parameters' => ['sometimes', 'nullable', 'array'],
            'required' => ['sometimes', 'boolean'],
        ];
    }
}
