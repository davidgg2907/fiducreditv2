<?php

namespace App\Repositories;

use App\Models\PldProductPolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class PldProductPolicyRepository
{
    public function paginate(array $options = []): LengthAwarePaginator
    {
        $query = PldProductPolicy::query();
        $columns = Schema::getColumnListing('pld_product_policies');

        foreach ($options['filter'] ?? [] as $field => $value) {
            if (!in_array($field, $columns, true)) {
                throw ValidationException::withMessages([
                    'filter' => 'Filtro no permitido.',
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

        $this->includeRelations($query, $options['include'] ?? '');

        return $query->orderBy($sort, $options['direction'] ?? 'desc')
            ->paginate($options['per_page'] ?? 25);
    }

    public function findOrFail(string $id, string $include = ''): PldProductPolicy
    {
        $query = PldProductPolicy::query();
        $this->includeRelations($query, $include);

        return $query->findOrFail($id);
    }

    public function create(array $data): PldProductPolicy
    {
        return PldProductPolicy::query()->create($data);
    }

    public function update(string $id, array $data): PldProductPolicy
    {
        $record = PldProductPolicy::query()->lockForUpdate()->findOrFail($id);
        $record->fill($data);
        $record->save();

        return $record->refresh();
    }

    private function includeRelations(Builder $query, string $include): void
    {
        if ($include === '') {
            return;
        }

        $relations = array_unique(array_filter(array_map(
            'trim',
            explode(',', $include)
        )));

        if (count($relations) > 6) {
            throw ValidationException::withMessages([
                'include' => 'Máximo seis relaciones.',
            ]);
        }

        $model = new PldProductPolicy();

        foreach ($relations as $relation) {
            if (!preg_match('/^[a-zA-Z][a-zA-Z0-9]*$/', $relation)
                || !method_exists($model, $relation)
                || !($model->{$relation}() instanceof Relation)) {
                throw ValidationException::withMessages([
                    'include' => 'Relación no admitida.',
                ]);
            }

            $related = $model->{$relation}()->getRelated()->getTable();

            if (str_starts_with($related, 'pld_')) {
                abort_unless(
                    in_array('pld-data.view', request()->user()?->permissions() ?? [], true),
                    403,
                    'Se requiere permiso de cumplimiento.'
                );
            }
        }

        $query->with($relations);
    }
}
