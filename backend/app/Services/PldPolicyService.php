<?php

namespace App\Services;

use App\Models\PldPolicy;
use App\Repositories\PldPolicyRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PldPolicyService
{
    public function __construct(private readonly PldPolicyRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): PldPolicy
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): PldPolicy
    {
        return DB::transaction(
            fn (): PldPolicy => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): PldPolicy
    {
        return DB::transaction(
            fn (): PldPolicy => $this->repository->update($id, $attributes)
        );
    }
}
