<?php

namespace App\Services;

use App\Models\CreditDocumentCheck;
use App\Repositories\CreditDocumentCheckRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditDocumentCheckService
{
    public function __construct(private readonly CreditDocumentCheckRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditDocumentCheck
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditDocumentCheck
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditDocumentCheck => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditDocumentCheck
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditDocumentCheck => $this->repository->update($id, $attributes)
        );
    }
}
