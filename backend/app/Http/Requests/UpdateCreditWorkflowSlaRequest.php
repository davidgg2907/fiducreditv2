<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditWorkflowSlaRequest extends FormRequest
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
            'step_id' => ['sometimes', 'uuid', 'exists:credit_workflow_steps,id', Rule::unique('credit_workflow_sla', 'step_id')->ignore($this->route('id'))],
            'target_minutes' => ['sometimes', 'integer'],
            'warning_minutes' => ['sometimes', 'nullable', 'integer'],
            'escalation_minutes' => ['sometimes', 'nullable', 'integer'],
            'calendar_type' => ['sometimes', 'string', 'max:30'],
            'timezone' => ['sometimes', 'string', 'max:64'],
            'escalation_role_id' => ['sometimes', 'nullable', 'integer', 'exists:roles,id'],
            'enabled' => ['sometimes', 'boolean'],
        ];
    }
}
