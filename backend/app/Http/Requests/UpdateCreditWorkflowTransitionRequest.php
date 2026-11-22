<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditWorkflowTransitionRequest extends FormRequest
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
            'workflow_version_id' => ['sometimes', 'uuid', 'exists:credit_workflow_versions,id'],
            'from_step_id' => ['sometimes', 'uuid', 'exists:credit_workflow_steps,id'],
            'to_step_id' => ['sometimes', 'uuid', 'exists:credit_workflow_steps,id'],
            'code' => ['sometimes', 'string', 'max:60'],
            'name' => ['sometimes', 'string', 'max:120'],
            'action' => ['sometimes', 'string', 'max:40'],
            'requires_reason' => ['sometimes', 'boolean'],
            'requires_authorization' => ['sometimes', 'boolean'],
            'enabled' => ['sometimes', 'boolean'],
        ];
    }
}
