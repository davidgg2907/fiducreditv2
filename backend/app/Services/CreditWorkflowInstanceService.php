<?php

namespace App\Services;

use App\Models\CreditWorkflowInstance;
use App\Repositories\CreditWorkflowInstanceRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditWorkflowInstanceService
{
    public function __construct(private readonly CreditWorkflowInstanceRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditWorkflowInstance
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditWorkflowInstance
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditWorkflowInstance => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditWorkflowInstance
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditWorkflowInstance => $this->repository->update($id, $attributes)
        );
    }
}
