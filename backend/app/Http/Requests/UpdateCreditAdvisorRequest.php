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
            'user_id' => ['sometimes', 'integer', 'exists:users,id'],
            'company_id' => ['sometimes', 'uuid', 'exists:credit_companies,id'],
            'branch_id' => ['sometimes', 'uuid', 'exists:credit_branches,id'],
            'employee_code' => ['sometimes', 'string', 'max:255'],
            'active' => ['sometimes', 'boolean'],
        ];
    }
}
