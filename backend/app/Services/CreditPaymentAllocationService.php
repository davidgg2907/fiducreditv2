<?php

namespace App\Services;

use App\Models\CreditPaymentAllocation;
use App\Repositories\CreditPaymentAllocationRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditPaymentAllocationService
{
    public function __construct(private readonly CreditPaymentAllocationRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditPaymentAllocation
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditPaymentAllocation
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditPaymentAllocation => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditPaymentAllocation
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditPaymentAllocation => $this->repository->update($id, $attributes)
        );
    }
}
