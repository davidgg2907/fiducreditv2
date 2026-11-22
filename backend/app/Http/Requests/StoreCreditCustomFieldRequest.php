<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditCustomFieldRequest extends FormRequest
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
            'company_id' => ['required', 'uuid', 'exists:credit_companies,id'],
            'field_key' => ['required', 'string', 'max:255'],
            'label' => ['required', 'string', 'max:255'],
            'data_type' => ['required', 'string', 'max:255'],
            'options' => ['sometimes', 'nullable', 'array'],
            'sensitive' => ['sometimes', 'boolean'],
        ];
    }
}
