<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditProductFeeRequest extends FormRequest
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
            'product_version_id' => ['sometimes', 'uuid', 'exists:credit_product_versions,id'],
            'code' => ['sometimes', 'string', 'max:255'],
            'name' => ['sometimes', 'string', 'max:255'],
            'calculation_type' => ['sometimes', 'string', 'max:255', 'in:porcentaje,fijo,fija'],
            'amount' => ['sometimes', 'numeric'],
            'taxable' => ['sometimes', 'boolean'],
            'active' => ['sometimes', 'boolean'],
        ];
    }
}
