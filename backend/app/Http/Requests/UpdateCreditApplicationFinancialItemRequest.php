<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditApplicationFinancialItemRequest extends FormRequest
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
            'entry_type' => ['sometimes', 'string', 'max:255'],
            'concept' => ['sometimes', 'string', 'max:255'],
            'counterparty' => ['sometimes', 'nullable', 'string', 'max:255'],
            'amount' => ['sometimes', 'numeric'],
            'frequency' => ['sometimes', 'string', 'max:255'],
            'verified' => ['sometimes', 'boolean'],
            'observations' => ['sometimes', 'nullable', 'string'],
            'captured_by' => ['sometimes', 'integer', 'exists:users,id'],
        ];
    }
}
