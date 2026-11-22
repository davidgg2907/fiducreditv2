<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditBureauInquiryRequest extends FormRequest
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
            'provider' => ['sometimes', 'string', 'max:255'],
            'score' => ['sometimes', 'nullable', 'integer'],
            'external_reference' => ['sometimes', 'nullable', 'string', 'max:255'],
            'result' => ['sometimes', 'string', 'max:255'],
            'report_storage_path' => ['sometimes', 'nullable', 'string', 'max:255'],
            'consulted_at' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
