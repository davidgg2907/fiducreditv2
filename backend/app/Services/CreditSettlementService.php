<?php

namespace App\Services;

use App\Models\CreditSettlement;
use App\Repositories\CreditSettlementRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditSettlementService
{
    public function __construct(private readonly CreditSettlementRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditSettlement
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditSettlement
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditSettlement => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditSettlement
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditSettlement => $this->repository->update($id, $attributes)
        );
    }
}
