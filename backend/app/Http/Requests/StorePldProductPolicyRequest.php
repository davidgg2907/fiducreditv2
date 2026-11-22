<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StorePldProductPolicyRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        if ($user?->is_superadmin !== true) {
            return false;
        }

        return in_array('pld-data.write', $user->permissions(), true);
    }

    public function rules(): array
    {
        return [
            'product_version_id' => ['required', 'uuid', 'exists:credit_product_versions,id'],
            'policy_version_id' => ['required', 'uuid', 'exists:pld_policy_versions,id'],
            'enabled' => ['sometimes', 'boolean'],
        ];
    }
}
