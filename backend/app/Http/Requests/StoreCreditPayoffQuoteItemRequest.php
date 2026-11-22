<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditPayoffQuoteItemRequest extends FormRequest
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
            'quote_id' => ['required', 'uuid', 'exists:credit_payoff_quotes,id'],
            'component' => ['required', 'string', 'max:40'],
            'description' => ['required', 'string', 'max:150'],
            'amount' => ['required', 'numeric'],
            'sort_order' => ['required', 'integer'],
        ];
    }
}
