<?php

namespace App\Services;

use App\Models\CreditWorkflowVersion;
use App\Repositories\CreditWorkflowVersionRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditWorkflowVersionService
{
    public function __construct(private readonly CreditWorkflowVersionRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditWorkflowVersion
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditWorkflowVersion
    {
        return DB::transaction(
            fn (): CreditWorkflowVersion => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditWorkflowVersion
    {
        return DB::transaction(
            fn (): CreditWorkflowVersion => $this->repository->update($id, $attributes)
        );
    }
}
