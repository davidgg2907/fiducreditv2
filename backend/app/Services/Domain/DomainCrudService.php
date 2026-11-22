<?php

namespace App\Services\Domain;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

final class DomainCrudService
{
    public function paginate(string $modelClass, array $options): LengthAwarePaginator
    {
        $model = new $modelClass();
        $query = $modelClass::query();
        $columns = Schema::getColumnListing($model->getTable());

        foreach ($options['filter'] ?? [] as $field => $value) {
            if (!in_array($field, $columns, true)) {
                throw ValidationException::withMessages([
                    'filter' => 'El campo solicitado no admite filtros.',
                ]);
            }

            if ($value !== null) {
                $query->where($field, $value);
            }
        }

        $sort = $options['sort'] ?? 'created_at';

        if (!in_array($sort, $columns, true)) {
            throw ValidationException::withMessages([
                'sort' => 'Campo de ordenamiento no permitido.',
            ]);
        }

        $this->includeRelations($query, $model, $options['include'] ?? '');
        $query->orderBy($sort, $options['direction'] ?? 'desc');

        return $query->paginate($options['per_page'] ?? 25);
    }

    public function find(string $modelClass, string $id, string $includes = ''): Model
    {
        $query = $modelClass::query();
        $this->includeRelations($query, new $modelClass(), $includes);

        return $query->findOrFail($id);
    }

    public function create(string $modelClass, array $attributes): Model
    {
        return DB::transaction(function () use ($modelClass, $attributes): Model {
            $model = new $modelClass();
            $model->fill($attributes);
            $model->save();

            return $model->refresh();
        });
    }

    public function update(string $modelClass, string $id, array $attributes): Model
    {
        return DB::transaction(function () use ($modelClass, $id, $attributes): Model {
            $model = $modelClass::query()->lockForUpdate()->findOrFail($id);
            $model->fill($attributes);
            $model->save();

            return $model->refresh();
        });
    }

    private function includeRelations($query, Model $model, string $includes): void
    {
        if ($includes === '') {
            return;
        }

        $relations = array_unique(array_filter(array_map(
            'trim',
            explode(',', $includes)
        )));

        if (count($relations) > 6) {
            throw ValidationException::withMessages([
                'include' => 'Se admiten máximo seis relaciones.',
            ]);
        }

        foreach ($relations as $relation) {
            if (!preg_match('/^[a-zA-Z][a-zA-Z0-9]*$/', $relation)
                || !method_exists($model, $relation)
                || !$model->{$relation}() instanceof Relation) {
                throw ValidationException::withMessages([
                    'include' => 'Relación no permitida.',
                ]);
            }

            $relatedTable = $model->{$relation}()->getRelated()->getTable();

            if (str_starts_with($relatedTable, 'pld_')) {
                $permissions = request()->user()?->permissions() ?? [];

                if (!in_array('pld-data.view', $permissions, true)) {
                    throw ValidationException::withMessages([
                        'include' => 'La relación requiere autorización de cumplimiento.',
                    ]);
                }
            }
        }

        $query->with($relations);
    }
}
