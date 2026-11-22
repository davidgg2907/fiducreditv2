<?php

namespace App\Services;

use App\Models\CreditProductRule;
use App\Repositories\CreditProductRuleRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditProductRuleService
{
    public function __construct(private readonly CreditProductRuleRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditProductRule
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditProductRule
    {
        return DB::transaction(
            fn (): CreditProductRule => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditProductRule
    {
        return DB::transaction(
            fn (): CreditProductRule => $this->repository->update($id, $attributes)
        );
    }
}
