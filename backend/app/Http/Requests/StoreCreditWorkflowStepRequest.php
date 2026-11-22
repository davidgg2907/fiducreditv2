<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditWorkflowStepRequest extends FormRequest
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
            'workflow_version_id' => ['required', 'uuid', 'exists:credit_workflow_versions,id'],
            'code' => ['required', 'string', 'max:60'],
            'name' => ['required', 'string', 'max:160'],
            'step_type' => ['required', 'string', 'max:40'],
            'application_status' => ['required', 'string', 'max:40'],
            'application_substatus' => ['sometimes', 'nullable', 'string', 'max:60'],
            'sort_order' => ['required', 'integer'],
            'is_initial' => ['sometimes', 'boolean'],
            'is_terminal' => ['sometimes', 'boolean'],
            'allow_manual_assignment' => ['sometimes', 'boolean'],
            'metadata' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
