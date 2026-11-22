<?php

namespace App\Services;

use App\Models\CreditWorkflowSla;
use App\Repositories\CreditWorkflowSlaRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditWorkflowSlaService
{
    public function __construct(private readonly CreditWorkflowSlaRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditWorkflowSla
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditWorkflowSla
    {
        return DB::transaction(
            fn (): CreditWorkflowSla => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditWorkflowSla
    {
        return DB::transaction(
            fn (): CreditWorkflowSla => $this->repository->update($id, $attributes)
        );
    }
}
