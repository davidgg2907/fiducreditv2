<?php

namespace App\Services;

use App\Models\CreditLoanRestructure;
use App\Repositories\CreditLoanRestructureRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditLoanRestructureService
{
    public function __construct(private readonly CreditLoanRestructureRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditLoanRestructure
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditLoanRestructure
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLoanRestructure => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditLoanRestructure
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLoanRestructure => $this->repository->update($id, $attributes)
        );
    }
}
