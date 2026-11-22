<?php

namespace App\Services;

use App\Models\CreditLinePolicy;
use App\Repositories\CreditLinePolicyRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditLinePolicyService
{
    public function __construct(private readonly CreditLinePolicyRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditLinePolicy
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditLinePolicy
    {
        return DB::transaction(
            fn (): CreditLinePolicy => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditLinePolicy
    {
        return DB::transaction(
            fn (): CreditLinePolicy => $this->repository->update($id, $attributes)
        );
    }
}
