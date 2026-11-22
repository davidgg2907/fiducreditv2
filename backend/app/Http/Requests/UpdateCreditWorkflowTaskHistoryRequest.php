<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditWorkflowTaskHistoryRequest extends FormRequest
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
            'task_id' => ['sometimes', 'uuid', 'exists:credit_workflow_tasks,id'],
            'actor_id' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'event_type' => ['sometimes', 'string', 'max:50'],
            'from_status' => ['sometimes', 'nullable', 'string', 'max:30'],
            'to_status' => ['sometimes', 'nullable', 'string', 'max:30'],
            'previous_assignee' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'new_assignee' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'reason' => ['sometimes', 'nullable', 'string'],
            'details' => ['sometimes', 'nullable', 'array'],
            'occurred_at' => ['sometimes', 'date'],
        ];
    }
}
