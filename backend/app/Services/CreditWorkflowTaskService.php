<?php

namespace App\Services;

use App\Models\CreditWorkflowTask;
use App\Repositories\CreditWorkflowTaskRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditWorkflowTaskService
{
    public function __construct(private readonly CreditWorkflowTaskRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditWorkflowTask
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditWorkflowTask
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditWorkflowTask => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditWorkflowTask
    {
        abort(405, 'Requiere servicio transaccional especializado.');

        return DB::transaction(
            fn (): CreditWorkflowTask => $this->repository->update($id, $attributes)
        );
    }
}
