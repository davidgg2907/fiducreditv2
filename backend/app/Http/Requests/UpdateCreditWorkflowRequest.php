<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditWorkflowRequest extends FormRequest
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
            'company_id' => ['sometimes', 'uuid', 'exists:credit_companies,id'],
            'product_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_products,id'],
            'code' => ['sometimes', 'string', 'max:60'],
            'name' => ['sometimes', 'string', 'max:160'],
            'description' => ['sometimes', 'nullable', 'string'],
            'enabled' => ['sometimes', 'boolean'],

            'steps' => ['sometimes', 'array', 'max:200'],
            'steps.*' => ['array:id,code,name,step_type,application_status,application_substatus,is_initial,is_terminal,allow_manual_assignment,metadata,rules,roles'],
            'steps.*.id' => ['nullable', 'uuid', 'distinct'],
            'steps.*.code' => ['required', 'string', 'max:60', 'distinct'],
            'steps.*.name' => ['required', 'string', 'max:160'],
            'steps.*.step_type' => ['required', 'string', 'max:40'],
            'steps.*.application_status' => ['required', 'string', 'max:40'],
            'steps.*.application_substatus' => ['nullable', 'string', 'max:60'],
            'steps.*.is_initial' => ['boolean'],
            'steps.*.is_terminal' => ['boolean'],
            'steps.*.allow_manual_assignment' => ['boolean'],
            'steps.*.metadata' => ['nullable', 'array'],
            'steps.*.rules' => ['present', 'array', 'max:200'],
            'steps.*.rules.*' => ['array:code,rule_type,operator,parameters,blocking,enabled,transition_id'],
            'steps.*.rules.*.code' => ['required', 'string', 'max:70'],
            'steps.*.rules.*.rule_type' => ['required', 'string', 'max:50'],
            'steps.*.rules.*.operator' => ['required', 'string', 'max:15'],
            'steps.*.rules.*.parameters' => ['present', 'array'],
            'steps.*.rules.*.blocking' => ['boolean'],
            'steps.*.rules.*.enabled' => ['boolean'],
            'steps.*.rules.*.transition_id' => ['nullable', 'uuid'],
            'steps.*.roles' => ['present', 'array', 'max:200'],
            'steps.*.roles.*' => ['array:role_id,can_view,can_claim,can_process,can_assign'],
            'steps.*.roles.*.role_id' => ['required', 'integer', 'exists:roles,id'],
            'steps.*.roles.*.can_view' => ['boolean'],
            'steps.*.roles.*.can_claim' => ['boolean'],
            'steps.*.roles.*.can_process' => ['boolean'],
            'steps.*.roles.*.can_assign' => ['boolean'],
            'source_version_id' => ['nullable', 'uuid'],
            'created_by' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
        ];
    }
}
