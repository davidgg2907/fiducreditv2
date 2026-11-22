<?php

namespace App\Services;

use App\Models\CreditDocumentValidationRule;
use App\Repositories\CreditDocumentValidationRuleRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditDocumentValidationRuleService
{
    public function __construct(private readonly CreditDocumentValidationRuleRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditDocumentValidationRule
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditDocumentValidationRule
    {
        return DB::transaction(
            fn (): CreditDocumentValidationRule => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditDocumentValidationRule
    {
        return DB::transaction(
            fn (): CreditDocumentValidationRule => $this->repository->update($id, $attributes)
        );
    }
}
