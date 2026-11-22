<?php

namespace App\Services;

use App\Models\CreditBranch;
use App\Repositories\CreditBranchRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditBranchService
{
    public function __construct(private readonly CreditBranchRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditBranch
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditBranch
    {
        return DB::transaction(
            fn (): CreditBranch => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditBranch
    {
        return DB::transaction(
            fn (): CreditBranch => $this->repository->update($id, $attributes)
        );
    }
}
