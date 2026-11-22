<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditPayoffQuoteItemRequest extends FormRequest
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
            'quote_id' => ['sometimes', 'uuid', 'exists:credit_payoff_quotes,id'],
            'component' => ['sometimes', 'string', 'max:40'],
            'description' => ['sometimes', 'string', 'max:150'],
            'amount' => ['sometimes', 'numeric'],
            'sort_order' => ['sometimes', 'integer'],
        ];
    }
}
