<?php

namespace App\Services;

use App\Models\CreditLoanTerm;
use App\Repositories\CreditLoanTermRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditLoanTermService
{
    public function __construct(private readonly CreditLoanTermRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditLoanTerm
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditLoanTerm
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLoanTerm => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditLoanTerm
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLoanTerm => $this->repository->update($id, $attributes)
        );
    }
}
