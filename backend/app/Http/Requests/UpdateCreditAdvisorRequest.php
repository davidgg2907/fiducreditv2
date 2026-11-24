<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditAdvisorRequest extends FormRequest
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
            'company_id' => ['sometimes', 'uuid', 'exists:credit_companies,id'],
            'branch_id' => ['sometimes', 'uuid', 'exists:credit_branches,id'],
            'employee_code' => ['sometimes', 'string', 'max:255'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:20'],
            'contact_email' => ['sometimes', 'nullable', 'email', 'max:255'],
            'has_system_access' => ['sometimes', 'boolean'],
            'active' => ['sometimes', 'boolean'],
            'street' => ['sometimes', 'nullable', 'string', 'max:255'],
            'neighborhood' => ['sometimes', 'nullable', 'string', 'max:255'],
            'city' => ['sometimes', 'nullable', 'string', 'max:255'],
            'state' => ['sometimes', 'nullable', 'string', 'max:255'],
            'municipality' => ['sometimes', 'nullable', 'string', 'max:255'],
            'postal_code' => ['sometimes', 'nullable', 'regex:/^\d{5}$/'],
            'new_user' => ['sometimes', 'array'],
            'new_user.name' => ['sometimes', 'string', 'max:255'],
            'new_user.email' => ['sometimes', 'nullable', 'email', 'max:255', Rule::unique('users','email')],
            'new_user.password' => ['sometimes', 'nullable', 'string', 'min:12', 'confirmed'],
            'new_user.password_confirmation' => ['sometimes', 'string', 'min:12'],
            'new_user.role_id' => ['sometimes', 'nullable', 'integer', 'exists:roles,id'],
        ];
    }
}
