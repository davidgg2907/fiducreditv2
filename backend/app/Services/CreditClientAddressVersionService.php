<?php

namespace App\Services;

use App\Models\CreditClientAddressVersion;
use App\Repositories\CreditClientAddressVersionRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditClientAddressVersionService
{
    public function __construct(private readonly CreditClientAddressVersionRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditClientAddressVersion
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditClientAddressVersion
    {
        return DB::transaction(
            fn (): CreditClientAddressVersion => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditClientAddressVersion
    {
        return DB::transaction(
            fn (): CreditClientAddressVersion => $this->repository->update($id, $attributes)
        );
    }
}
