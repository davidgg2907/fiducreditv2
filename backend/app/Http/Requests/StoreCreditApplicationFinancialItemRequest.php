<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditApplicationFinancialItemRequest extends FormRequest
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
            'entry_type' => ['required', 'string', 'max:255'],
            'concept' => ['required', 'string', 'max:255'],
            'counterparty' => ['sometimes', 'nullable', 'string', 'max:255'],
            'amount' => ['required', 'numeric'],
            'frequency' => ['required', 'string', 'max:255'],
            'verified' => ['sometimes', 'boolean'],
            'observations' => ['sometimes', 'nullable', 'string'],
            'captured_by' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
