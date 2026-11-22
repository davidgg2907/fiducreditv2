<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StorePldPolicyVersionRequest extends FormRequest
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
            'policy_id' => ['required', 'uuid', 'exists:pld_policies,id'],
            'version' => ['required', 'integer'],
            'status' => ['sometimes', 'string', 'max:25'],
            'effective_from' => ['sometimes', 'nullable', 'date'],
            'effective_to' => ['sometimes', 'nullable', 'date'],
            'approved_by' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'approved_at' => ['sometimes', 'nullable', 'date'],
            'monitoring_config' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
