<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditApplicationConditionRequest extends FormRequest
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
            'application_id' => ['sometimes', 'uuid', 'exists:credit_applications,id'],
            'annual_interest_rate' => ['sometimes', 'numeric'],
            'interest_method' => ['sometimes', 'string', 'max:255'],
            'approved_term' => ['sometimes', 'integer'],
            'payment_frequency' => ['sometimes', 'string', 'max:255'],
            'amortization_method' => ['sometimes', 'string', 'max:255'],
            'opening_fee' => ['sometimes', 'numeric'],
            'conditions_accepted_at' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
