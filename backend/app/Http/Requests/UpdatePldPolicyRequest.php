<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdatePldPolicyRequest extends FormRequest
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
            'company_id' => ['sometimes', 'uuid', 'exists:credit_companies,id'],
            'code' => ['sometimes', 'string', 'max:60'],
            'name' => ['sometimes', 'string', 'max:160'],
            'regulatory_regime' => ['sometimes', 'string', 'max:60'],
            'enabled' => ['sometimes', 'boolean'],
        ];
    }
}
