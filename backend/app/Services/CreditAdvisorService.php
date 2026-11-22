<?php

namespace App\Services;

use App\Models\CreditAdvisor;
use App\Repositories\CreditAdvisorRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditAdvisorService
{
    public function __construct(private readonly CreditAdvisorRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditAdvisor
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditAdvisor
    {
        return DB::transaction(
            fn (): CreditAdvisor => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditAdvisor
    {
        return DB::transaction(
            fn (): CreditAdvisor => $this->repository->update($id, $attributes)
        );
    }
}
