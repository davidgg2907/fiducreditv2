<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreCreditApplicationFinancialItemsBatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_superadmin === true;
    }

    public function rules(): array
    {
        return [
            'items' => ['required', 'array', 'min:1', 'max:200'],
            'items.*.entry_type' => ['required', 'in:income,expense'],
            'items.*.concept' => ['required', 'string', 'max:255'],
            'items.*.counterparty' => ['sometimes', 'nullable', 'string', 'max:255'],
            'items.*.amount' => ['required', 'numeric', 'gt:0'],
            'items.*.frequency' => ['required', 'string', 'max:50'],
            'items.*.observations' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
