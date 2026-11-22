<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditLoanTermRequest extends FormRequest
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
            'loan_id' => ['sometimes', 'uuid', 'exists:credit_loans,id'],
            'version' => ['sometimes', 'integer'],
            'interest_rate_type' => ['sometimes', 'string', 'max:30'],
            'ordinary_annual_rate' => ['sometimes', 'numeric'],
            'default_annual_rate' => ['sometimes', 'numeric'],
            'day_count_convention' => ['sometimes', 'string', 'max:30'],
            'amortization_method' => ['sometimes', 'string', 'max:30'],
            'payment_frequency' => ['sometimes', 'string', 'max:30'],
            'interest_calculation' => ['sometimes', 'string', 'max:30'],
            'rounding_mode' => ['sometimes', 'string', 'max:30'],
            'grace_days' => ['sometimes', 'integer'],
            'tax_on_interest' => ['sometimes', 'boolean'],
            'tax_rate' => ['sometimes', 'numeric'],
            'valid_from' => ['sometimes', 'date'],
            'valid_to' => ['sometimes', 'nullable', 'date'],
            'terms_snapshot' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
