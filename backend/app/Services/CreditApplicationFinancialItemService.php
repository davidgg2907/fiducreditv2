<?php

namespace App\Services;

use App\Models\CreditApplicationFinancialItem;
use App\Repositories\CreditApplicationFinancialItemRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditApplicationFinancialItemService
{
    public function __construct(private readonly CreditApplicationFinancialItemRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditApplicationFinancialItem
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditApplicationFinancialItem
    {
        return DB::transaction(
            fn (): CreditApplicationFinancialItem => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditApplicationFinancialItem
    {
        return DB::transaction(
            fn (): CreditApplicationFinancialItem => $this->repository->update($id, $attributes)
        );
    }
}
