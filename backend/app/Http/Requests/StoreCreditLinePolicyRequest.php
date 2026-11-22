<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditLinePolicyRequest extends FormRequest
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
            'line_type' => ['sometimes', 'string', 'max:30'],
            'replenish_principal' => ['sometimes', 'boolean'],
            'max_simultaneous_loans' => ['sometimes', 'integer'],
            'max_utilization_pct' => ['sometimes', 'numeric'],
            'min_draw_amount' => ['sometimes', 'numeric'],
            'require_new_approval_per_draw' => ['sometimes', 'boolean'],
            'enabled' => ['sometimes', 'boolean'],
            'product_version_id' => ['required', 'string'],
        ];
    }
}
