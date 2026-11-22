<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditApplicationDocumentRequest extends FormRequest
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
            'document_type_id' => ['required', 'uuid', 'exists:credit_document_types,id'],
            'previous_document_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_application_documents,id'],
            'version' => ['required', 'integer'],
            'storage_disk' => ['required', 'string', 'max:255'],
            'storage_path' => ['required', 'string', 'max:255'],
            'original_filename' => ['required', 'string', 'max:255'],
            'mime_type' => ['required', 'string', 'max:255'],
            'size_bytes' => ['required', 'integer'],
            'sha256' => ['required', 'string', 'max:64'],
            'status' => ['sometimes', 'string', 'max:255'],
            'rejection_reason' => ['sometimes', 'nullable', 'string'],
            'uploaded_by' => ['required', 'integer', 'exists:users,id'],
            'validated_at' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
