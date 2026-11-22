<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditWorkflowRequest extends FormRequest
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
            'product_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_products,id'],
            'code' => ['sometimes', 'string', 'max:60'],
            'name' => ['sometimes', 'string', 'max:160'],
            'description' => ['sometimes', 'nullable', 'string'],
            'enabled' => ['sometimes', 'boolean'],
            'created_by' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
        ];
    }
}
