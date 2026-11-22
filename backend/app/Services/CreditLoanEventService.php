<?php

namespace App\Services;

use App\Models\CreditLoanEvent;
use App\Repositories\CreditLoanEventRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditLoanEventService
{
    public function __construct(private readonly CreditLoanEventRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditLoanEvent
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditLoanEvent
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLoanEvent => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditLoanEvent
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLoanEvent => $this->repository->update($id, $attributes)
        );
    }
}
