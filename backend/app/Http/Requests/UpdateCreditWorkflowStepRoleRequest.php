<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditWorkflowStepRoleRequest extends FormRequest
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
            'step_id' => ['sometimes', 'uuid', 'exists:credit_workflow_steps,id'],
            'role_id' => ['sometimes', 'integer', 'exists:roles,id'],
            'can_view' => ['sometimes', 'boolean'],
            'can_claim' => ['sometimes', 'boolean'],
            'can_process' => ['sometimes', 'boolean'],
            'can_assign' => ['sometimes', 'boolean'],
        ];
    }
}
