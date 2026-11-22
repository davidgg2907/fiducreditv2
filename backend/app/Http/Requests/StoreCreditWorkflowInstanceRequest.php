<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditWorkflowInstanceRequest extends FormRequest
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
            'application_id' => ['required', 'uuid', 'exists:credit_applications,id', Rule::unique('credit_workflow_instances', 'application_id')],
            'workflow_version_id' => ['required', 'uuid', 'exists:credit_workflow_versions,id'],
            'current_step_id' => ['required', 'uuid', 'exists:credit_workflow_steps,id'],
            'status' => ['sometimes', 'string', 'max:30'],
            'started_at' => ['required', 'date'],
            'completed_at' => ['sometimes', 'nullable', 'date'],
            'started_by' => ['required', 'integer', 'exists:users,id'],
            'lock_version' => ['sometimes', 'integer'],
        ];
    }
}
