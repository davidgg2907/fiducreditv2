<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditWorkflowVersionRequest extends FormRequest
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
            'workflow_id' => ['sometimes', 'uuid', 'exists:credit_workflows,id'],
            'version' => ['sometimes', 'integer'],
            'status' => ['sometimes', 'string', 'max:25'],
            'is_default' => ['sometimes', 'boolean'],
            'published_at' => ['sometimes', 'nullable', 'date'],
            'retired_at' => ['sometimes', 'nullable', 'date'],
            'published_by' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'configuration_hash' => ['sometimes', 'nullable', 'string', 'max:64'],
        ];
    }
}
