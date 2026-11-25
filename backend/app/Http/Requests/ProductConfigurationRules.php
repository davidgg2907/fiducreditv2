<?php

namespace App\Http\Requests;

final class ProductConfigurationRules
{
    public static function rules(bool $creating): array
    {
        $rules = ['configuration' => [$creating ? 'required' : 'sometimes', 'array']];
        $version = (new StoreCreditProductVersionRequest())->rules();
        foreach (['product_id', 'version', 'active', 'effective_from', 'effective_to'] as $key) {
            unset($version[$key]);
        }
        foreach ($version as $key => $constraints) {
            $rules['configuration.'.$key] = array_map(
                fn ($rule) => !$creating && $rule === 'required' ? 'sometimes' : $rule,
                $constraints
            );
        }
        foreach ([
            'rules' => StoreCreditProductRuleRequest::class,
            'fields' => StoreCreditProductFieldRequest::class,
            'documents' => StoreCreditProductDocumentRequest::class,
            'fees' => StoreCreditProductFeeRequest::class,
        ] as $section => $request) {
            $rules[$section] = ['sometimes', 'array', 'max:500'];
            $fields = (new $request())->rules();
            unset($fields['product_version_id']);
            $rules[$section.'.*'] = ['array:'.implode(',', array_keys($fields))];
            foreach ($fields as $key => $constraints) {
                $rules[$section.'.*.'.$key] = $constraints;
            }
        }
        $rules['configuration'] = [$creating ? 'required' : 'sometimes', 'array:'.implode(',', array_keys($version))];
        return $rules;
    }
}
