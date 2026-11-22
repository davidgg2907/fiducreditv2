<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditApplicationFinancialSummaryRequest extends FormRequest
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
            'monthly_income' => ['required', 'numeric'],
            'monthly_expenses' => ['required', 'numeric'],
            'monthly_debt_obligations' => ['required', 'numeric'],
            'proposed_monthly_payment' => ['sometimes', 'numeric'],
            'disposable_income' => ['required', 'numeric'],
            'debt_to_income_ratio' => ['required', 'numeric'],
            'result' => ['sometimes', 'string', 'max:255'],
            'analyzed_by' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
