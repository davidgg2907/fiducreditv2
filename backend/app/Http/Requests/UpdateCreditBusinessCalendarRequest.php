<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditBusinessCalendarRequest extends FormRequest
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
            'company_id' => ['sometimes', 'uuid', 'exists:credit_companies,id'],
            'code' => ['sometimes', 'string', 'max:50'],
            'name' => ['sometimes', 'string', 'max:120'],
            'timezone' => ['sometimes', 'string', 'max:64', 'timezone'],
            'non_business_weekdays' => ['sometimes', 'array', 'max:6'],
            'non_business_weekdays.*' => ['integer', 'between:0,6', 'distinct'],
            'due_date_adjustment' => ['sometimes', 'string', 'max:40'],
            'holidays' => ['sometimes', 'array', 'max:500'],
            'holidays.*' => ['required', 'array:id,holiday_date,description,recurring'],
            'holidays.*.id' => ['sometimes', 'uuid', 'distinct'],
            'holidays.*.holiday_date' => ['required', 'date_format:Y-m-d', 'distinct'],
            'holidays.*.description' => ['required', 'string', 'max:150'],
            'holidays.*.recurring' => ['required', 'boolean'],
            'enabled' => ['sometimes', 'boolean'],
        ];
    }
}
