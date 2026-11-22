<?php

namespace App\Services;

use App\Models\CreditApplicationField;
use App\Repositories\CreditApplicationFieldRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditApplicationFieldService
{
    public function __construct(private readonly CreditApplicationFieldRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditApplicationField
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditApplicationField
    {
        return DB::transaction(
            fn (): CreditApplicationField => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditApplicationField
    {
        return DB::transaction(
            fn (): CreditApplicationField => $this->repository->update($id, $attributes)
        );
    }
}
