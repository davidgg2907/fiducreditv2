<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditPaymentApplicationPriorityRequest extends FormRequest
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
            'policy_id' => ['required', 'uuid', 'exists:credit_payment_application_policies,id'],
            'component' => ['required', 'string', 'max:40'],
            'priority' => ['required', 'integer'],
            'enabled' => ['sometimes', 'boolean'],
        ];
    }
}
