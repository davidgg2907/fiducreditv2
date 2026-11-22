<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditPaymentAllocationRequest extends FormRequest
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
            'payment_id' => ['sometimes', 'uuid', 'exists:credit_payments,id'],
            'loan_id' => ['sometimes', 'uuid', 'exists:credit_loans,id'],
            'installment_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_amortization_installments,id'],
            'component' => ['sometimes', 'string', 'max:35'],
            'amount' => ['sometimes', 'numeric'],
            'allocation_order' => ['sometimes', 'integer'],
            'value_date' => ['sometimes', 'date'],
            'status' => ['sometimes', 'string', 'max:25'],
        ];
    }
}
