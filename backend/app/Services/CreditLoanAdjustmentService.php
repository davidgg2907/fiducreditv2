<?php

namespace App\Services;

use App\Models\CreditLoanAdjustment;
use App\Repositories\CreditLoanAdjustmentRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditLoanAdjustmentService
{
    public function __construct(private readonly CreditLoanAdjustmentRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditLoanAdjustment
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditLoanAdjustment
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLoanAdjustment => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditLoanAdjustment
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLoanAdjustment => $this->repository->update($id, $attributes)
        );
    }
}
