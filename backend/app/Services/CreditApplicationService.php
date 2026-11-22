<?php

namespace App\Services;

use App\Models\CreditApplication;
use App\Repositories\CreditApplicationRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditApplicationService
{
    public function __construct(private readonly CreditApplicationRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditApplication
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditApplication
    {
        return DB::transaction(
            fn (): CreditApplication => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditApplication
    {
        return DB::transaction(
            fn (): CreditApplication => $this->repository->update($id, $attributes)
        );
    }
}
