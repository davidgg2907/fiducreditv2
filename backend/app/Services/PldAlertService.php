<?php

namespace App\Services;

use App\Models\PldAlert;
use App\Repositories\PldAlertRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PldAlertService
{
    public function __construct(private readonly PldAlertRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): PldAlert
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): PldAlert
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): PldAlert => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): PldAlert
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): PldAlert => $this->repository->update($id, $attributes)
        );
    }
}
