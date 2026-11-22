<?php

namespace App\Services;

use App\Models\CreditProductFee;
use App\Repositories\CreditProductFeeRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditProductFeeService
{
    public function __construct(private readonly CreditProductFeeRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditProductFee
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditProductFee
    {
        return DB::transaction(
            fn (): CreditProductFee => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditProductFee
    {
        return DB::transaction(
            fn (): CreditProductFee => $this->repository->update($id, $attributes)
        );
    }
}
