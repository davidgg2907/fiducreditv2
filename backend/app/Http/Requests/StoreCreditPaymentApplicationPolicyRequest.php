<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditPaymentApplicationPolicyRequest extends FormRequest
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
            'product_version_id' => ['required', 'uuid', 'exists:credit_product_versions,id', Rule::unique('credit_payment_application_policies', 'product_version_id')],
            'prepayment_mode' => ['sometimes', 'string', 'max:40'],
            'allow_early_payment' => ['sometimes', 'boolean'],
            'recalculate_interest_after_prepayment' => ['sometimes', 'boolean'],
            'allow_overpayment' => ['sometimes', 'boolean'],
            'surplus_handling' => ['sometimes', 'string', 'max:40'],
            'enabled' => ['sometimes', 'boolean'],
        ];
    }
}
