<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditClientRequest extends FormRequest
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
            'addresses' => ['sometimes', 'array', 'max:50'],
            'addresses.*' => ['array:id,address_type,primary,active,street,exterior_number,interior_number,neighborhood,city,municipality,state,postal_code,country,latitude,longitude'],
            'addresses.*.id' => ['sometimes', 'uuid', 'distinct'],
            'addresses.*.address_type' => ['required', 'string', 'max:255'],
            'addresses.*.primary' => ['required', 'boolean'],
            'addresses.*.active' => ['required', 'boolean'],
            'addresses.*.street' => ['required', 'string', 'max:255'],
            'addresses.*.exterior_number' => ['nullable', 'string', 'max:255'],
            'addresses.*.interior_number' => ['nullable', 'string', 'max:255'],
            'addresses.*.neighborhood' => ['required', 'string', 'max:255'],
            'addresses.*.city' => ['required', 'string', 'max:255'],
            'addresses.*.municipality' => ['required', 'string', 'max:255'],
            'addresses.*.state' => ['required', 'string', 'max:255'],
            'addresses.*.postal_code' => ['required', 'string', 'max:10'],
            'addresses.*.country' => ['required', 'string', 'size:2'],
            'addresses.*.latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'addresses.*.longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'bank_accounts' => ['sometimes', 'array', 'max:50'],
            'bank_accounts.*' => ['array:id,bank_code,bank_name,holder_name,clabe,account_last4,account_type,primary,active'],
            'bank_accounts.*.id' => ['sometimes', 'uuid', 'distinct'],
            'bank_accounts.*.bank_code' => ['nullable', 'string', 'max:5'],
            'bank_accounts.*.bank_name' => ['required', 'string', 'max:255'],
            'bank_accounts.*.holder_name' => ['required', 'string', 'max:255'],
            'bank_accounts.*.clabe' => ['nullable', 'digits:18'],
            'bank_accounts.*.account_last4' => ['nullable', 'digits:4'],
            'bank_accounts.*.account_type' => ['required', 'string', 'max:255'],
            'bank_accounts.*.primary' => ['required', 'boolean'],
            'bank_accounts.*.active' => ['required', 'boolean'],
            'company_id' => ['required', 'uuid', 'exists:credit_companies,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'second_last_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'birth_date' => ['sometimes', 'nullable', 'date'],
            'rfc' => ['sometimes', 'nullable', 'string', 'max:13'],
            'curp' => ['sometimes', 'nullable', 'string', 'max:18'],
            'ine_folio' => ['sometimes', 'nullable', 'string', 'max:255'],
            'passport_number' => ['sometimes', 'nullable', 'string', 'max:255'],
            'nss' => ['sometimes', 'nullable', 'string', 'max:255'],
            'health_provider' => ['sometimes', 'nullable', 'string', 'max:255'],
            'email' => ['sometimes', 'nullable', 'string', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:20'],
            'status' => ['sometimes', 'string', 'max:255'],
        ];
    }
}
