<?php

namespace App\Services;

use App\Models\CreditProductVersion;
use App\Repositories\CreditProductVersionRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditProductVersionService
{
    public function __construct(private readonly CreditProductVersionRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditProductVersion
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditProductVersion
    {
        if (isset($attributes['configuracion_plazos'])) ConfiguracionPlazos::validar($attributes['configuracion_plazos']);
        return DB::transaction(
            fn (): CreditProductVersion => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditProductVersion
    {
        if (isset($attributes['configuracion_plazos'])) ConfiguracionPlazos::validar($attributes['configuracion_plazos']);
        return DB::transaction(
            fn (): CreditProductVersion => $this->repository->update($id, $attributes)
        );
    }
}
