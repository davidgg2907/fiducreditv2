<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditApplicationDocumentRequest extends FormRequest
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
            'document_type_id' => ['sometimes', 'uuid', 'exists:credit_document_types,id'],
            'previous_document_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_application_documents,id'],
            'version' => ['sometimes', 'integer'],
            'storage_disk' => ['sometimes', 'string', 'max:255'],
            'storage_path' => ['sometimes', 'string', 'max:255'],
            'original_filename' => ['sometimes', 'string', 'max:255'],
            'mime_type' => ['sometimes', 'string', 'max:255'],
            'size_bytes' => ['sometimes', 'integer'],
            'sha256' => ['sometimes', 'string', 'max:64'],
            'status' => ['sometimes', 'string', 'max:255'],
            'rejection_reason' => ['sometimes', 'nullable', 'string'],
            'uploaded_by' => ['sometimes', 'integer', 'exists:users,id'],
            'validated_at' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
