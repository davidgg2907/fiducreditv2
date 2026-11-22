<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditProductRuleRequest extends FormRequest
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
            'product_version_id' => ['required', 'uuid', 'exists:credit_product_versions,id'],
            'rule_code' => ['required', 'string', 'max:255'],
            'operator' => ['required', 'string', 'max:255'],
            'rule_value' => ['required', 'array'],
            'rejection_reason' => ['sometimes', 'nullable', 'string', 'max:255'],
            'mandatory' => ['sometimes', 'boolean'],
        ];
    }
}
