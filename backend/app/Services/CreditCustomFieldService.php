<?php

namespace App\Services;

use App\Models\CreditCustomField;
use App\Repositories\CreditCustomFieldRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditCustomFieldService
{
    public function __construct(private readonly CreditCustomFieldRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditCustomField
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditCustomField
    {
        return DB::transaction(
            fn (): CreditCustomField => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditCustomField
    {
        return DB::transaction(
            fn (): CreditCustomField => $this->repository->update($id, $attributes)
        );
    }
}
