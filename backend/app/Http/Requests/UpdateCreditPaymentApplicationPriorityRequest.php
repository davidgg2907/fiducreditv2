<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditPaymentApplicationPriorityRequest extends FormRequest
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
            'policy_id' => ['sometimes', 'uuid', 'exists:credit_payment_application_policies,id'],
            'component' => ['sometimes', 'string', 'max:40'],
            'priority' => ['sometimes', 'integer'],
            'enabled' => ['sometimes', 'boolean'],
        ];
    }
}
