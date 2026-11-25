<?php

namespace App\Services;

use App\Models\CreditProduct;
use App\Repositories\CreditProductRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditProductService
{
    public function __construct(private readonly CreditProductRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditProduct
    {
        return $this->repository->findOrFail($id, $include)->load(['currentVersion.creditProductRules', 'currentVersion.creditProductFields', 'currentVersion.creditProductDocuments', 'currentVersion.creditProductFees']);
    }

    public function create(array $attributes): CreditProduct
    {
        return DB::transaction(
            fn (): CreditProduct => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditProduct
    {
        return DB::transaction(
            fn (): CreditProduct => $this->repository->update($id, $attributes)
        );
    }
}
