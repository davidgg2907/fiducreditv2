<?php

namespace App\Services;

use App\Models\CreditProductDocument;
use App\Repositories\CreditProductDocumentRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CreditProductDocumentService
{
    public function __construct(private readonly CreditProductDocumentRepository $repository)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters);
    }

    public function find(string $id, string $include = ''): CreditProductDocument
    {
        return $this->repository->findOrFail($id, $include);
    }

    public function create(array $attributes): CreditProductDocument
    {
        return DB::transaction(
            fn (): CreditProductDocument => $this->repository->create($attributes)
        );
    }

    public function update(string $id, array $attributes): CreditProductDocument
    {
        return DB::transaction(
            fn (): CreditProductDocument => $this->repository->update($id, $attributes)
        );
    }
}
