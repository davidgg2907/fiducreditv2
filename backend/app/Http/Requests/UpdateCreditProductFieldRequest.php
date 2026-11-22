<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditProductFieldRequest extends FormRequest
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
            'product_version_id' => ['sometimes', 'uuid', 'exists:credit_product_versions,id'],
            'custom_field_id' => ['sometimes', 'uuid', 'exists:credit_custom_fields,id'],
            'scope' => ['sometimes', 'string', 'max:255'],
            'required' => ['sometimes', 'boolean'],
            'visible' => ['sometimes', 'boolean'],
            'display_order' => ['sometimes', 'integer'],
        ];
    }
}
