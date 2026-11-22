<?php

namespace App\Services;

use App\Models\CreditClient;
use App\Repositories\CreditClientRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditClientService
{
    public function __construct(private readonly CreditClientRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditClient
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditClient
    {
        return DB::transaction(
            fn (): CreditClient => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditClient
    {
        return DB::transaction(
            fn (): CreditClient => $this->repository->update($id, $attributes)
        );
    }
}
