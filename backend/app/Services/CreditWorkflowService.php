<?php

namespace App\Services;

use App\Models\CreditWorkflow;
use App\Repositories\CreditWorkflowRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditWorkflowService
{
    public function __construct(private readonly CreditWorkflowRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditWorkflow
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditWorkflow
    {
        return DB::transaction(
            fn (): CreditWorkflow => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditWorkflow
    {
        return DB::transaction(
            fn (): CreditWorkflow => $this->repository->update($id, $attributes)
        );
    }
}
