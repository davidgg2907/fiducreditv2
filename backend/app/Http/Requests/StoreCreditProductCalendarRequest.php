<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditProductCalendarRequest extends FormRequest
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
            'product_version_id' => ['required', 'uuid', 'exists:credit_product_versions,id', Rule::unique('credit_product_calendars', 'product_version_id')],
            'calendar_id' => ['required', 'uuid', 'exists:credit_business_calendars,id'],
        ];
    }
}
