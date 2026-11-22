<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditWorkflowStepRequest extends FormRequest
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
            'code' => ['sometimes', 'string', 'max:60'],
            'name' => ['sometimes', 'string', 'max:160'],
            'step_type' => ['sometimes', 'string', 'max:40'],
            'application_status' => ['sometimes', 'string', 'max:40'],
            'application_substatus' => ['sometimes', 'nullable', 'string', 'max:60'],
            'sort_order' => ['sometimes', 'integer'],
            'is_initial' => ['sometimes', 'boolean'],
            'is_terminal' => ['sometimes', 'boolean'],
            'allow_manual_assignment' => ['sometimes', 'boolean'],
            'metadata' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
