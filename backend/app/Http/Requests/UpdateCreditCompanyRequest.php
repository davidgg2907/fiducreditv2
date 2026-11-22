<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditCompanyRequest extends FormRequest
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
            'legal_name' => ['sometimes', 'string', 'max:255'],
            'trade_name' => ['sometimes', 'string', 'max:255'],
            'rfc' => ['sometimes', 'string', 'max:13', Rule::unique('credit_companies', 'rfc')->ignore($this->route('id'))],
            'status' => ['sometimes', 'string', 'max:255'],
        ];
    }
}
