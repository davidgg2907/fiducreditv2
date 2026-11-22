<?php

namespace App\Services;

use App\Models\CreditPaymentApplicationPriority;
use App\Repositories\CreditPaymentApplicationPriorityRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditPaymentApplicationPriorityService
{
    public function __construct(private readonly CreditPaymentApplicationPriorityRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditPaymentApplicationPriority
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditPaymentApplicationPriority
    {
        return DB::transaction(
            fn (): CreditPaymentApplicationPriority => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditPaymentApplicationPriority
    {
        return DB::transaction(
            fn (): CreditPaymentApplicationPriority => $this->repository->update($id, $attributes)
        );
    }
}
