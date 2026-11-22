<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditApplicationConditionRequest extends FormRequest
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
            'application_id' => ['required', 'uuid', 'exists:credit_applications,id'],
            'annual_interest_rate' => ['required', 'numeric'],
            'interest_method' => ['required', 'string', 'max:255'],
            'approved_term' => ['required', 'integer'],
            'payment_frequency' => ['required', 'string', 'max:255'],
            'amortization_method' => ['required', 'string', 'max:255'],
            'opening_fee' => ['sometimes', 'numeric'],
            'conditions_accepted_at' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
