<?php

namespace App\Services;

use App\Models\CreditApplicationFinancialSummary;
use App\Repositories\CreditApplicationFinancialSummaryRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditApplicationFinancialSummaryService
{
    public function __construct(private readonly CreditApplicationFinancialSummaryRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditApplicationFinancialSummary
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditApplicationFinancialSummary
    {
        return DB::transaction(
            fn (): CreditApplicationFinancialSummary => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditApplicationFinancialSummary
    {
        return DB::transaction(
            fn (): CreditApplicationFinancialSummary => $this->repository->update($id, $attributes)
        );
    }
}
