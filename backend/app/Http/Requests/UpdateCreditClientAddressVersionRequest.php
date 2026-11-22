<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditClientAddressVersionRequest extends FormRequest
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
            'address_id' => ['sometimes', 'uuid', 'exists:credit_client_addresses,id'],
            'version' => ['sometimes', 'integer'],
            'street' => ['sometimes', 'string', 'max:255'],
            'exterior_number' => ['sometimes', 'nullable', 'string', 'max:255'],
            'interior_number' => ['sometimes', 'nullable', 'string', 'max:255'],
            'neighborhood' => ['sometimes', 'string', 'max:255'],
            'city' => ['sometimes', 'string', 'max:255'],
            'municipality' => ['sometimes', 'string', 'max:255'],
            'state' => ['sometimes', 'string', 'max:255'],
            'postal_code' => ['sometimes', 'string', 'max:10'],
            'country' => ['sometimes', 'string', 'max:2'],
            'latitude' => ['sometimes', 'nullable', 'numeric'],
            'longitude' => ['sometimes', 'nullable', 'numeric'],
            'source' => ['sometimes', 'string', 'max:255'],
            'valid_from' => ['sometimes', 'nullable', 'date'],
            'valid_to' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
