<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditBusinessCalendarRequest extends FormRequest
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
            'company_id' => ['required', 'uuid', 'exists:credit_companies,id'],
            'code' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:120'],
            'timezone' => ['sometimes', 'string', 'max:64'],
            'non_business_weekdays' => ['required', 'array'],
            'due_date_adjustment' => ['sometimes', 'string', 'max:40'],
            'enabled' => ['sometimes', 'boolean'],
        ];
    }
}
