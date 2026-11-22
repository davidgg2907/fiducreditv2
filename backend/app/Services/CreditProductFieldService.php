<?php

namespace App\Services;

use App\Models\CreditProductField;
use App\Repositories\CreditProductFieldRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditProductFieldService
{
    public function __construct(private readonly CreditProductFieldRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditProductField
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditProductField
    {
        return DB::transaction(
            fn (): CreditProductField => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditProductField
    {
        return DB::transaction(
            fn (): CreditProductField => $this->repository->update($id, $attributes)
        );
    }
}
