<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditProductDocumentRequest extends FormRequest
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
            'document_type_id' => ['sometimes', 'uuid', 'exists:credit_document_types,id'],
            'required' => ['sometimes', 'boolean'],
            'min_files' => ['sometimes', 'integer'],
            'max_files' => ['sometimes', 'integer'],
            'display_order' => ['sometimes', 'integer'],
        ];
    }
}
