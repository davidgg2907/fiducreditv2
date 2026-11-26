<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCreditProductVersionRequest extends FormRequest
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
            'product_id' => ['sometimes', 'uuid', 'exists:credit_products,id'],
            'version' => ['sometimes', 'integer'],
            'min_amount' => ['sometimes', 'numeric'],
            'max_amount' => ['sometimes', 'numeric'],
            'min_term' => ['sometimes', 'integer'],
            'max_term' => ['sometimes', 'integer'],
            'configuracion_plazos' => ['sometimes', 'array'],
            'term_unit' => ['sometimes', 'string', 'max:255', 'in:dia,semana,mes,anio'],
            'min_annual_rate' => ['sometimes', 'numeric'],
            'max_annual_rate' => ['sometimes', 'numeric'],
            'rate_type' => ['sometimes', 'string', 'max:255', 'in:fija,variable'],
            'interest_method' => ['sometimes', 'string', 'max:255', 'in:saldo_insoluto'],
            'min_dti' => ['sometimes', 'numeric'],
            'max_dti' => ['sometimes', 'numeric'],
            'min_bureau_score' => ['sometimes', 'nullable', 'integer'],
            'amortization_method' => ['sometimes', 'string', 'max:255', 'in:frances'],
            'payment_frequency' => ['sometimes', 'string', 'max:255', 'in:unico,diario,semanal,catorcenal,quincenal,mensual,bimestral,trimestral,cuatrimestral,semestral,anual'],
            'currency' => ['sometimes', 'string', 'max:3'],
            'requires_bureau' => ['sometimes', 'boolean'],
            'active' => ['sometimes', 'boolean'],
            'effective_from' => ['sometimes', 'nullable', 'date'],
            'effective_to' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
