<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditWorkflowStepRuleRequest extends FormRequest
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
            'step_id' => ['required', 'uuid', 'exists:credit_workflow_steps,id'],
            'transition_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_workflow_transitions,id'],
            'code' => ['required', 'string', 'max:70'],
            'rule_type' => ['required', 'string', 'max:50'],
            'operator' => ['required', 'string', 'max:15'],
            'parameters' => ['required', 'array'],
            'blocking' => ['sometimes', 'boolean'],
            'enabled' => ['sometimes', 'boolean'],
        ];
    }
}
