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
            'entry_type' => ['sometimes', 'string', 'max:255'],
            'concept' => ['sometimes', 'string', 'max:255'],
            'counterparty' => ['sometimes', 'nullable', 'string', 'max:255'],
            'amount' => ['sometimes', 'numeric'],
            'frequency' => ['sometimes', 'string', 'max:255'],
            'observations' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
