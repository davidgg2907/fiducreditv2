<?php

namespace App\Services;

use App\Models\PldAlertAction;
use App\Repositories\PldAlertActionRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PldAlertActionService
{
    public function __construct(private readonly PldAlertActionRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): PldAlertAction
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): PldAlertAction
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): PldAlertAction => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): PldAlertAction
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): PldAlertAction => $this->repository->update($id, $attributes)
        );
    }
}
