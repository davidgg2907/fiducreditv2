<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditProductVersionRequest extends FormRequest
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
            'product_id' => ['required', 'uuid', 'exists:credit_products,id'],
            'version' => ['required', 'integer'],
            'min_amount' => ['required', 'numeric'],
            'max_amount' => ['required', 'numeric'],
            'min_term' => ['required', 'integer'],
            'max_term' => ['required', 'integer'],
            'configuracion_plazos' => ['sometimes', 'array'],
            'term_unit' => ['sometimes', 'string', 'max:255'],
            'min_annual_rate' => ['required', 'numeric'],
            'max_annual_rate' => ['required', 'numeric'],
            'rate_type' => ['sometimes', 'string', 'max:255'],
            'interest_method' => ['sometimes', 'string', 'max:255'],
            'min_dti' => ['sometimes', 'numeric'],
            'max_dti' => ['sometimes', 'numeric'],
            'min_bureau_score' => ['sometimes', 'nullable', 'integer'],
            'amortization_method' => ['sometimes', 'string', 'max:255'],
            'payment_frequency' => ['sometimes', 'string', 'max:255'],
            'currency' => ['sometimes', 'string', 'max:3'],
            'requires_bureau' => ['sometimes', 'boolean'],
            'active' => ['sometimes', 'boolean'],
            'effective_from' => ['sometimes', 'nullable', 'date'],
            'effective_to' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
