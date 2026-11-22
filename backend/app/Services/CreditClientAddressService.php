<?php

namespace App\Services;

use App\Models\CreditClientAddress;
use App\Repositories\CreditClientAddressRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditClientAddressService
{
    public function __construct(private readonly CreditClientAddressRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditClientAddress
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditClientAddress
    {
        return DB::transaction(
            fn (): CreditClientAddress => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditClientAddress
    {
        return DB::transaction(
            fn (): CreditClientAddress => $this->repository->update($id, $attributes)
        );
    }
}
