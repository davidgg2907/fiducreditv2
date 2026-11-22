<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditContractRequest extends FormRequest
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
            'line_id' => ['sometimes', 'uuid', 'exists:credit_lines,id'],
            'application_id' => ['sometimes', 'uuid', 'exists:credit_applications,id'],
            'contract_number' => ['sometimes', 'string', 'max:70', Rule::unique('credit_contracts', 'contract_number')->ignore($this->route('id'))],
            'document_version' => ['sometimes', 'string', 'max:30'],
            'storage_disk' => ['sometimes', 'nullable', 'string', 'max:40'],
            'storage_path' => ['sometimes', 'nullable', 'string', 'max:255'],
            'sha256' => ['sometimes', 'nullable', 'string', 'max:64'],
            'signed_at' => ['sometimes', 'nullable', 'date'],
            'status' => ['sometimes', 'string', 'max:30'],
            'signer_snapshot' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
