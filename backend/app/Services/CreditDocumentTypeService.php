<?php

namespace App\Services;

use App\Models\CreditDocumentType;
use App\Repositories\CreditDocumentTypeRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditDocumentTypeService
{
    public function __construct(private readonly CreditDocumentTypeRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditDocumentType
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditDocumentType
    {
        return DB::transaction(
            fn (): CreditDocumentType => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditDocumentType
    {
        return DB::transaction(
            fn (): CreditDocumentType => $this->repository->update($id, $attributes)
        );
    }
}
