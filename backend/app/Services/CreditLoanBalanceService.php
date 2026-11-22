<?php

namespace App\Services;

use App\Models\CreditLoanBalance;
use App\Repositories\CreditLoanBalanceRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditLoanBalanceService
{
    public function __construct(private readonly CreditLoanBalanceRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditLoanBalance
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditLoanBalance
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLoanBalance => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditLoanBalance
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLoanBalance => $this->repository->update($id, $attributes)
        );
    }
}
