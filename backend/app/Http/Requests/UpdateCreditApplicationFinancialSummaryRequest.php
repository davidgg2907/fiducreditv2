<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditApplicationFinancialSummaryRequest extends FormRequest
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
            'monthly_income' => ['sometimes', 'numeric'],
            'monthly_expenses' => ['sometimes', 'numeric'],
            'monthly_debt_obligations' => ['sometimes', 'numeric'],
            'proposed_monthly_payment' => ['sometimes', 'numeric'],
            'disposable_income' => ['sometimes', 'numeric'],
            'debt_to_income_ratio' => ['sometimes', 'numeric'],
            'result' => ['sometimes', 'string', 'max:255'],
            'analyzed_by' => ['sometimes', 'integer', 'exists:users,id'],
        ];
    }
}
