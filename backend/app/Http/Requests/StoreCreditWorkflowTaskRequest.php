<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditWorkflowTaskRequest extends FormRequest
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
            'instance_id' => ['required', 'uuid', 'exists:credit_workflow_instances,id'],
            'step_id' => ['required', 'uuid', 'exists:credit_workflow_steps,id'],
            'branch_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_branches,id'],
            'assigned_to' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'assigned_role_id' => ['sometimes', 'nullable', 'integer', 'exists:roles,id'],
            'task_type' => ['required', 'string', 'max:40'],
            'status' => ['sometimes', 'string', 'max:30'],
            'priority' => ['sometimes', 'integer'],
            'due_at' => ['sometimes', 'nullable', 'date'],
            'assigned_at' => ['sometimes', 'nullable', 'date'],
            'started_at' => ['sometimes', 'nullable', 'date'],
            'finished_at' => ['sometimes', 'nullable', 'date'],
            'resolution_notes' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
