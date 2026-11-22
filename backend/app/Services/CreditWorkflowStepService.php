<?php

namespace App\Services;

use App\Models\CreditWorkflowStep;
use App\Repositories\CreditWorkflowStepRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditWorkflowStepService
{
    public function __construct(private readonly CreditWorkflowStepRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditWorkflowStep
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditWorkflowStep
    {
        return DB::transaction(
            fn (): CreditWorkflowStep => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditWorkflowStep
    {
        return DB::transaction(
            fn (): CreditWorkflowStep => $this->repository->update($id, $attributes)
        );
    }
}
