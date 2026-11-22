<?php

namespace App\Http\Requests\Domain;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

abstract class DomainWriteRequest extends FormRequest
{
    protected string $modelClass;

    public function authorize(): bool
    {
        $user = $this->user();

        if ($user?->is_superadmin !== true) {
            return false;
        }

        $table = (new $this->modelClass())->getTable();

        return !str_starts_with($table, 'pld_')
            || in_array('pld-data.write', $user->permissions(), true);
    }

    public function rules(): array
    {
        $table = (new $this->modelClass())->getTable();
        $blocked = [
            'id', 'created_at', 'updated_at', 'deleted_at',
            'password', 'remember_token', 'mfa_secret',
        ];

        $rules = [];

        foreach (Schema::getColumnListing($table) as $column) {
            if (in_array($column, $blocked, true)) {
                continue;
            }

            $type = Schema::getColumnType($table, $column);
            $columnRules = ['sometimes', 'nullable'];

            if (in_array($type, ['integer', 'bigint', 'smallint', 'tinyint'], true)) {
                $columnRules[] = 'integer';
            } elseif (in_array($type, ['decimal', 'numeric', 'float', 'double'], true)) {
                $columnRules[] = 'numeric';
            } elseif (in_array($type, ['boolean', 'bool'], true)) {
                $columnRules[] = 'boolean';
            } elseif (in_array($type, ['json', 'jsonb'], true)) {
                $columnRules[] = 'array';
            } elseif (in_array($type, ['date', 'datetime', 'timestamp'], true)) {
                $columnRules[] = 'date';
            } else {
                $columnRules[] = 'string';
            }

            if (str_ends_with($column, '_id') && !in_array($column, [
                'user_id', 'role_id', 'actor_id', 'assigned_to',
            ], true)) {
                $columnRules[] = 'max:64';
            }

            $rules[$column] = $columnRules;
        }

        return $rules;
    }
}
