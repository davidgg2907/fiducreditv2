<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditApplicationGuarantorRequest extends FormRequest
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
            'full_name' => ['required', 'string', 'max:255'],
            'rfc' => ['sometimes', 'nullable', 'string', 'max:13'],
            'relationship' => ['required', 'string', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:20'],
            'monthly_income' => ['sometimes', 'nullable', 'numeric'],
        ];
    }
}
