<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditApplicationAnalyseRequest extends FormRequest
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
            'analyst_id' => ['sometimes', 'integer', 'exists:users,id'],
            'status' => ['sometimes', 'string', 'max:255'],
            'findings' => ['sometimes', 'nullable', 'string'],
            'recommendation' => ['sometimes', 'nullable', 'string'],
            'completed_at' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
