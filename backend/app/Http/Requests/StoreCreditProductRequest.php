<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditProductRequest extends FormRequest
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
        return array_merge([
            'company_id' => ['required', 'uuid', 'exists:credit_companies,id'],
            'parent_product_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_products,id'],
            'code' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string', 'max:255'],
            'status' => ['sometimes', 'string', 'max:255'],
        ], ProductConfigurationRules::rules(true));
    }
}
