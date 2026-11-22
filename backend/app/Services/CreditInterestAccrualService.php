<?php

namespace App\Services;

use App\Models\CreditInterestAccrual;
use App\Repositories\CreditInterestAccrualRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditInterestAccrualService
{
    public function __construct(private readonly CreditInterestAccrualRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditInterestAccrual
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditInterestAccrual
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditInterestAccrual => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditInterestAccrual
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditInterestAccrual => $this->repository->update($id, $attributes)
        );
    }
}
