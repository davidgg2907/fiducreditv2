<?php

namespace App\Services;

use App\Models\CreditLoanRateRevision;
use App\Repositories\CreditLoanRateRevisionRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditLoanRateRevisionService
{
    public function __construct(private readonly CreditLoanRateRevisionRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditLoanRateRevision
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditLoanRateRevision
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLoanRateRevision => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditLoanRateRevision
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLoanRateRevision => $this->repository->update($id, $attributes)
        );
    }
}
