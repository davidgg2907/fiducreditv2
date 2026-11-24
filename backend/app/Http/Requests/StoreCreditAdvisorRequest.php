<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditAdvisorRequest extends FormRequest
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
            'user_id' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'company_id' => ['required', 'uuid', 'exists:credit_companies,id'],
            'branch_id' => ['required', 'uuid', 'exists:credit_branches,id'],
            'employee_code' => ['required', 'string', 'max:255'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:20'],
            'contact_email' => ['sometimes', 'nullable', 'email', 'max:255'],
            'has_system_access' => ['required', 'boolean'],
            'active' => ['sometimes', 'boolean'],
            'street' => ['sometimes', 'nullable', 'string', 'max:255'],
            'neighborhood' => ['sometimes', 'nullable', 'string', 'max:255'],
            'city' => ['sometimes', 'nullable', 'string', 'max:255'],
            'state' => ['sometimes', 'nullable', 'string', 'max:255'],
            'municipality' => ['sometimes', 'nullable', 'string', 'max:255'],
            'postal_code' => ['sometimes', 'nullable', 'regex:/^\d{5}$/'],
            'new_user' => ['sometimes', 'array'],
            'new_user.name' => ['required_if:has_system_access,true', 'string', 'max:255'],
            'new_user.email' => ['required_if:has_system_access,true', 'nullable', 'email', 'max:255', Rule::unique('users','email')],
            'new_user.password' => ['required_if:has_system_access,true', 'nullable', 'string', 'min:12', 'confirmed'],
            'new_user.role_id' => ['required_if:has_system_access,true', 'nullable', 'integer', 'exists:roles,id'],
        ];
    }
}
