<?php

namespace App\Services;

use App\Models\CreditLoan;
use App\Repositories\CreditLoanRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditLoanService
{
    public function __construct(private readonly CreditLoanRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditLoan
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditLoan
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLoan => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditLoan
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLoan => $this->repository->update($id, $attributes)
        );
    }
}
