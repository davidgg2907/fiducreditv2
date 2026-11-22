<?php

namespace App\Services;

use App\Models\PldScreening;
use App\Repositories\PldScreeningRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PldScreeningService
{
    public function __construct(private readonly PldScreeningRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): PldScreening
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): PldScreening
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): PldScreening => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): PldScreening
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): PldScreening => $this->repository->update($id, $attributes)
        );
    }
}
