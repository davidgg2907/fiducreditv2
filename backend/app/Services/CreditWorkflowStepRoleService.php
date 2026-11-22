<?php

namespace App\Services;

use App\Models\CreditWorkflowStepRole;
use App\Repositories\CreditWorkflowStepRoleRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditWorkflowStepRoleService
{
    public function __construct(private readonly CreditWorkflowStepRoleRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditWorkflowStepRole
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditWorkflowStepRole
    {
        return DB::transaction(
            fn (): CreditWorkflowStepRole => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditWorkflowStepRole
    {
        return DB::transaction(
            fn (): CreditWorkflowStepRole => $this->repository->update($id, $attributes)
        );
    }
}
