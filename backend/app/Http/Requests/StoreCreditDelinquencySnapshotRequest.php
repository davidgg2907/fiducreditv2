<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditDelinquencySnapshotRequest extends FormRequest
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
            'loan_id' => ['required', 'uuid', 'exists:credit_loans,id'],
            'as_of_date' => ['required', 'date'],
            'days_past_due' => ['required', 'integer'],
            'overdue_installments' => ['required', 'integer'],
            'overdue_principal' => ['required', 'numeric'],
            'overdue_interest' => ['required', 'numeric'],
            'penalty_interest' => ['required', 'numeric'],
            'bucket' => ['required', 'string', 'max:30'],
        ];
    }
}
