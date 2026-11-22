<?php

namespace App\Services;

use App\Models\CreditWorkflowTransition;
use App\Repositories\CreditWorkflowTransitionRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditWorkflowTransitionService
{
    public function __construct(private readonly CreditWorkflowTransitionRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditWorkflowTransition
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditWorkflowTransition
    {
        return DB::transaction(
            fn (): CreditWorkflowTransition => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditWorkflowTransition
    {
        return DB::transaction(
            fn (): CreditWorkflowTransition => $this->repository->update($id, $attributes)
        );
    }
}
