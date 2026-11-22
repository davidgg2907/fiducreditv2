<?php

namespace App\Services;

use App\Models\CreditApplicationCondition;
use App\Repositories\CreditApplicationConditionRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditApplicationConditionService
{
    public function __construct(private readonly CreditApplicationConditionRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditApplicationCondition
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditApplicationCondition
    {
        return DB::transaction(
            fn (): CreditApplicationCondition => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditApplicationCondition
    {
        return DB::transaction(
            fn (): CreditApplicationCondition => $this->repository->update($id, $attributes)
        );
    }
}
