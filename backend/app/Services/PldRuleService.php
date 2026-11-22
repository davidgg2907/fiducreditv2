<?php

namespace App\Services;

use App\Models\PldRule;
use App\Repositories\PldRuleRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PldRuleService
{
    public function __construct(private readonly PldRuleRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): PldRule
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): PldRule
    {
        return DB::transaction(
            fn (): PldRule => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): PldRule
    {
        return DB::transaction(
            fn (): PldRule => $this->repository->update($id, $attributes)
        );
    }
}
