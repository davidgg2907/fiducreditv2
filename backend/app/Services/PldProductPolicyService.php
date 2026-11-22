<?php

namespace App\Services;

use App\Models\PldProductPolicy;
use App\Repositories\PldProductPolicyRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PldProductPolicyService
{
    public function __construct(private readonly PldProductPolicyRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): PldProductPolicy
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): PldProductPolicy
    {
        return DB::transaction(
            fn (): PldProductPolicy => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): PldProductPolicy
    {
        return DB::transaction(
            fn (): PldProductPolicy => $this->repository->update($id, $attributes)
        );
    }
}
