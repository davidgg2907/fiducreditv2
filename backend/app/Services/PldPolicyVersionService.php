<?php

namespace App\Services;

use App\Models\PldPolicyVersion;
use App\Repositories\PldPolicyVersionRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PldPolicyVersionService
{
    public function __construct(private readonly PldPolicyVersionRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): PldPolicyVersion
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): PldPolicyVersion
    {
        return DB::transaction(
            fn (): PldPolicyVersion => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): PldPolicyVersion
    {
        return DB::transaction(
            fn (): PldPolicyVersion => $this->repository->update($id, $attributes)
        );
    }
}
