<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditCustomFieldRequest extends FormRequest
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
            'company_id' => ['sometimes', 'uuid', 'exists:credit_companies,id'],
            'field_key' => ['sometimes', 'string', 'max:255'],
            'label' => ['sometimes', 'string', 'max:255'],
            'data_type' => ['sometimes', 'string', 'max:255'],
            'options' => ['sometimes', 'nullable', 'array'],
            'sensitive' => ['sometimes', 'boolean'],
        ];
    }
}
