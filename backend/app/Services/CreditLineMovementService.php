<?php

namespace App\Services;

use App\Models\CreditLineMovement;
use App\Repositories\CreditLineMovementRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditLineMovementService
{
    public function __construct(private readonly CreditLineMovementRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditLineMovement
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditLineMovement
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLineMovement => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditLineMovement
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLineMovement => $this->repository->update($id, $attributes)
        );
    }
}
