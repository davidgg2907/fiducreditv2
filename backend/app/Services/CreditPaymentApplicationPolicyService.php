<?php

namespace App\Services;

use App\Models\CreditPaymentApplicationPolicy;
use App\Repositories\CreditPaymentApplicationPolicyRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditPaymentApplicationPolicyService
{
    public function __construct(private readonly CreditPaymentApplicationPolicyRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditPaymentApplicationPolicy
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditPaymentApplicationPolicy
    {
        return DB::transaction(
            fn (): CreditPaymentApplicationPolicy => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditPaymentApplicationPolicy
    {
        return DB::transaction(
            fn (): CreditPaymentApplicationPolicy => $this->repository->update($id, $attributes)
        );
    }
}
