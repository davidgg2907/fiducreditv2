<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditPaymentAllocationRequest extends FormRequest
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
            'payment_id' => ['required', 'uuid', 'exists:credit_payments,id'],
            'loan_id' => ['required', 'uuid', 'exists:credit_loans,id'],
            'installment_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_amortization_installments,id'],
            'component' => ['required', 'string', 'max:35'],
            'amount' => ['required', 'numeric'],
            'allocation_order' => ['required', 'integer'],
            'value_date' => ['required', 'date'],
            'status' => ['sometimes', 'string', 'max:25'],
        ];
    }
}
