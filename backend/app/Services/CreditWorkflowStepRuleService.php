<?php

namespace App\Services;

use App\Models\CreditWorkflowStepRule;
use App\Repositories\CreditWorkflowStepRuleRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditWorkflowStepRuleService
{
    public function __construct(private readonly CreditWorkflowStepRuleRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditWorkflowStepRule
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditWorkflowStepRule
    {
        return DB::transaction(
            fn (): CreditWorkflowStepRule => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditWorkflowStepRule
    {
        return DB::transaction(
            fn (): CreditWorkflowStepRule => $this->repository->update($id, $attributes)
        );
    }
}
