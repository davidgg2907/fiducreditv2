<?php

namespace App\Services;

use App\Models\CreditPenaltyAccrual;
use App\Repositories\CreditPenaltyAccrualRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditPenaltyAccrualService
{
    public function __construct(private readonly CreditPenaltyAccrualRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditPenaltyAccrual
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditPenaltyAccrual
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditPenaltyAccrual => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditPenaltyAccrual
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditPenaltyAccrual => $this->repository->update($id, $attributes)
        );
    }
}
