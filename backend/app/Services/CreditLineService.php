<?php

namespace App\Services;

use App\Models\CreditLine;
use App\Repositories\CreditLineRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditLineService
{
    public function __construct(private readonly CreditLineRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditLine
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditLine
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLine => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditLine
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditLine => $this->repository->update($id, $attributes)
        );
    }
}
