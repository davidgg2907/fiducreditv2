<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCreditApplicationRequest extends FormRequest
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
            'client_id' => ['required', 'uuid', 'exists:credit_clients,id'],
            'product_version_id' => ['required', 'uuid', 'exists:credit_product_versions,id'],
            'advisor_id' => ['required', 'uuid', 'exists:credit_advisors,id'],
            'branch_id' => ['required', 'uuid', 'exists:credit_branches,id'],
            'address_version_id' => ['required', 'uuid', 'exists:credit_client_address_versions,id'],
            'bank_account_id' => ['sometimes', 'nullable', 'uuid', 'exists:credit_client_bank_accounts,id'],
            'application_number' => ['required', 'string', 'max:255', Rule::unique('credit_applications', 'application_number')],
            'requested_amount' => ['required', 'numeric'],
            'unidad_plazo' => ['sometimes','string','in:dia,semana,mes,anio'],
            'frecuencia_pago' => ['sometimes','string'],
            'requested_term' => ['required', 'integer', 'min:1'],
            'financial_items' => ['sometimes', 'array', 'max:200'],
            'financial_items.*.entry_type' => ['required', 'in:income,expense'],
            'financial_items.*.concept' => ['required', 'string', 'max:255'],
            'financial_items.*.counterparty' => ['sometimes', 'nullable', 'string', 'max:255'],
            'financial_items.*.amount' => ['required', 'numeric', 'gt:0'],
            'financial_items.*.frequency' => ['required', 'string', 'max:50'],
            'financial_items.*.observations' => ['sometimes', 'nullable', 'string'],
            'documents' => ['sometimes', 'array', 'max:30'],
            'documents.*.document_type_id' => ['required', 'uuid', 'exists:credit_document_types,id'],
            'documents.*.file' => ['required', 'file', 'max:10240'],
            'consents' => ['sometimes', 'array', 'max:30'],
            'consents.*.consent_type' => ['required', 'string', 'max:255'],
            'consents.*.version' => ['required', 'string', 'max:255'],
            'consents.*.accepted' => ['required', 'boolean'],
            'declared_income' => ['sometimes', 'nullable', 'numeric'],
            'declared_expenses' => ['sometimes', 'nullable', 'numeric'],
        ];
    }
}
