<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditDelinquencySnapshotRequest extends FormRequest
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
            'as_of_date' => ['sometimes', 'date'],
            'days_past_due' => ['sometimes', 'integer'],
            'overdue_installments' => ['sometimes', 'integer'],
            'overdue_principal' => ['sometimes', 'numeric'],
            'overdue_interest' => ['sometimes', 'numeric'],
            'penalty_interest' => ['sometimes', 'numeric'],
            'bucket' => ['sometimes', 'string', 'max:30'],
        ];
    }
}
