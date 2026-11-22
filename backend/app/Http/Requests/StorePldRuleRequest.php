<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StorePldRuleRequest extends FormRequest
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
            'policy_version_id' => ['required', 'uuid', 'exists:pld_policy_versions,id'],
            'code' => ['required', 'string', 'max:70'],
            'name' => ['required', 'string', 'max:150'],
            'event_type' => ['required', 'string', 'max:40'],
            'rule_type' => ['required', 'string', 'max:50'],
            'parameters' => ['required', 'array'],
            'severity' => ['sometimes', 'string', 'max:20'],
            'blocking' => ['sometimes', 'boolean'],
            'enabled' => ['sometimes', 'boolean'],
        ];
    }
}
