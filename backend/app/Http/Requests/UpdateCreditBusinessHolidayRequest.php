<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditBusinessHolidayRequest extends FormRequest
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
            'calendar_id' => ['sometimes', 'uuid', 'exists:credit_business_calendars,id'],
            'holiday_date' => ['sometimes', 'date'],
            'description' => ['sometimes', 'string', 'max:150'],
            'recurring' => ['sometimes', 'boolean'],
        ];
    }
}
