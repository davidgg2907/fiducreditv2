<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditContractRequest extends FormRequest
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
            'line_id' => ['required', 'uuid', 'exists:credit_lines,id'],
            'application_id' => ['required', 'uuid', 'exists:credit_applications,id'],
            'contract_number' => ['required', 'string', 'max:70', Rule::unique('credit_contracts', 'contract_number')],
            'document_version' => ['required', 'string', 'max:30'],
            'storage_disk' => ['sometimes', 'nullable', 'string', 'max:40'],
            'storage_path' => ['sometimes', 'nullable', 'string', 'max:255'],
            'sha256' => ['sometimes', 'nullable', 'string', 'max:64'],
            'signed_at' => ['sometimes', 'nullable', 'date'],
            'status' => ['sometimes', 'string', 'max:30'],
            'signer_snapshot' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
