<?php

namespace App\Services;

use App\Models\CreditCompany;
use App\Repositories\CreditCompanyRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditCompanyService
{
    public function __construct(private readonly CreditCompanyRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditCompany
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditCompany
    {
        return DB::transaction(
            fn (): CreditCompany => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditCompany
    {
        return DB::transaction(
            fn (): CreditCompany => $this->repository->update($id, $attributes)
        );
    }
}
