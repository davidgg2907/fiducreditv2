<?php

namespace App\Services;

use App\Models\CreditDrawdown;
use App\Repositories\CreditDrawdownRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditDrawdownService
{
    public function __construct(private readonly CreditDrawdownRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditDrawdown
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditDrawdown
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditDrawdown => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditDrawdown
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditDrawdown => $this->repository->update($id, $attributes)
        );
    }
}
