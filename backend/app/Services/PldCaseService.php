<?php

namespace App\Services;

use App\Models\PldCase;
use App\Repositories\PldCaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PldCaseService
{
    public function __construct(private readonly PldCaseRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): PldCase
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): PldCase
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): PldCase => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): PldCase
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): PldCase => $this->repository->update($id, $attributes)
        );
    }
}
