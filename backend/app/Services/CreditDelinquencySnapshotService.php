<?php

namespace App\Services;

use App\Models\CreditDelinquencySnapshot;
use App\Repositories\CreditDelinquencySnapshotRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditDelinquencySnapshotService
{
    public function __construct(private readonly CreditDelinquencySnapshotRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditDelinquencySnapshot
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditDelinquencySnapshot
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditDelinquencySnapshot => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditDelinquencySnapshot
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditDelinquencySnapshot => $this->repository->update($id, $attributes)
        );
    }
}
