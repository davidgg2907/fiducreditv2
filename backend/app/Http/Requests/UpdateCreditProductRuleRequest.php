<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditProductRuleRequest extends FormRequest
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
            'rule_code' => ['sometimes', 'string', 'max:255'],
            'operator' => ['sometimes', 'string', 'max:255'],
            'rule_value' => ['sometimes', 'array'],
            'rejection_reason' => ['sometimes', 'nullable', 'string', 'max:255'],
            'mandatory' => ['sometimes', 'boolean'],
        ];
    }
}
